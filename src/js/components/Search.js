import { h, Component } from 'preact';

export default class Search extends Component {

  constructor() {
    super()
    this.clickHandler = e => {
      return false
    }
    this.state.term = ''
  }

  handleChange(e) {
    this.state.term = e.target.value
    console.log('update state', this.state.term)
  }

  handleKeyInput(e) {
    if (e.charCode == 13 || e.keyCode == 13) {
      e.preventDefault();
      this.state.term = e.target.value
      this.state.clickHandler(this.state.term)
      return false
    }
  }

  render(props = {term:''}, state) {
    state.term = props.term

    if (props.clickHandler) state.clickHandler = props.clickHandler

    return <div class="form-group">
      <div class="input-group">
        <input class="form-control" value={state.term} onChange={this.handleChange.bind(this)} onKeyPress={this.handleKeyInput.bind(this)} />
        <span class="input-group-btn">
          <a class="btn btn-primary" onClick={() => state.clickHandler(this.state.term)}>
            <i class="glyphicon glyphicon-search"></i>
          </a>
        </span>
      </div>
    </div>
  }
}
