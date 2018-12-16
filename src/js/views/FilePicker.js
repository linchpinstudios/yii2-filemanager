import { h, Component } from 'preact';
import Search from '../components/Search'
import Thumbnail from '../components/Thumbnail'
import Pagination from '../components/Pagination';
import Selected from '../components/Selected';
import Axios from 'axios';
import Uploader from '../components/Uploader';

export default class FilePicker extends Component {

  constructor(props) {
    super(props);
    // set initial time:
    this.props = props
    this.state = this.setDefaultState(props)
  }

  setDefaultState(props) {
    return {
      images: [],
      selected: [],
      selectedIds: props.selected ? JSON.parse(props.selected) : [],
      limit: parseInt(props.limit),
      page: 1,
      term: '',
      pageCount: 10,
      showSelector: false,
    }
  }

  componentDidMount() {
    this.getSelected()
    this.getPage()
  }

  getSelected() {
    this.state.selectedIds.forEach(id => this.getById(id).then(image => this.state.selected.push(image)).catch(error => console.log(error)))
  }

  getById(id) {
    return new Promise((resolve, reject) => {
      Axios.get('/filemanager/files/view', {
        params: { id: id },
        headers: {
          Accept: 'application/json'
        }
      }).then(response => response.data).then(data => {
        console.log(data)
        resolve(data)
      }).catch(error => console.log('getById', reject(error)))
    })
  }

  addToSelected(image) {
    let match = this.state.selected.find(img => image === img)
    if (match) return
    if (this.state.limit > 0 && this.state.selected.length >= this.state.limit) {
      this.state.selected.pop()
      this.state.selectedIds.pop()
    }
    this.state.selected.push(image)
    this.state.selectedIds.push(image.id)
    this.setState({ selected: this.state.selected })
  }

  removeFromSelected(image) {
    let selected = this.state.selected.filter(img => image !== img)
    let selectedIds = this.state.selectedIds.filter(img => image.id !== img)
    this.setState({
      selected: selected,
      selectedIds: selectedIds,
    })
  }

  clickHandler(page) {
    this.getPage(page <= 0 ? 1 : page)
    return false
  }

  searchHandler(term = '') {
    this.setState({term: term})
    this.getPage()
    return false
  }

  getPage(page = 1) {
    let params = { page }

    if (this.state.term !== '') params["FilesSearch[title]"] = this.state.term
    this.clearThumbnails()
    Axios.get('/filemanager/files/index', {
      params,
      headers: {
        Accept: 'application/json'
      }
    }).then(response => response.data).then(data => {
      this.setState({
        page: page,
        images: data.images,
        pageCount: data.pageCount,
      })
    }).catch(error => console.log('getPage', error))
  }

  clearThumbnails () {
    this.setState({images: []})
  }

  thumbnails(images) {
    let components = []
    images.forEach((image) => {
      components.push(<Thumbnail image={image} clickHandler={this.addToSelected.bind(this)} />)
    })
    return components
  }

  toggleSelector() {
    let show = !this.state.showSelector
    this.setState({showSelector: show})
  }

  selector() {
    if (!this.state.showSelector) {
      return ''
    }
    return (<div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-6">
              <Search term={this.state.term} clickHandler={this.searchHandler.bind(this)} />
            </div>
            <div class="col-sm-6">
            <Uploader uploadCallback={image => this.addToSelected(image)}></Uploader>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            {this.thumbnails(this.state.images)}
          </div>
        </div>
        <div class="panel-footer">
          <Pagination page={this.state.page} pageCount={this.state.pageCount} clickHandler={this.clickHandler.bind(this)} />
        </div>
      </div>)
  }

  inputs() {
    let inputs = []
    console.log('inputs', this.state.limit)
    if (this.state.limit == 1) {
      this.state.selectedIds.forEach((id, key) => inputs.push(<input type="hidden" value={id} name={`${this.props.target}`} />))
    } else {
      this.state.selectedIds.forEach((id, key) => inputs.push(<input type="hidden" value={id} name={`${this.props.target}[]`} />))
    }
    return inputs
  }

  render(props, state) {
    return (<div>
      {this.inputs()}
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row" style={styles.selected.backgroundColor}>
            <Selected images={state.selected} clickHandler={this.removeFromSelected.bind(this)} />
          </div>
          <div class="row">
            <div class="col-sm-12">
              <a class="list-group-item active text-center" onClick={this.toggleSelector.bind(this)}>{this.state.showSelector ? 'Hide' : 'Select'} Files</a>
            </div>
          </div>
        </div>
      </div>
      { this.selector() }
    </div>)
  }
}

const styles = {
  selected: {
    backgroundColor: '#eeeff2'
  }
}
