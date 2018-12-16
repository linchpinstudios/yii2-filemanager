import { h, Component } from 'preact';
import Thumbnail from '../components/Thumbnail'

export default class Selected extends Component {

  constructor() {
    super()
    this.state.images = []
    this.state.clickHandler = () => {}
  }

  thumbnails(images) {
    let components = []
    images.forEach((image, key) => {
      components.push(<Thumbnail image={image} size="2" clickHandler={this.state.clickHandler} />)
    })
    return components
  }

  render(props = { images: [] }, state) {
    if (props.clickHandler) state.clickHandler = props.clickHandler
    state.images = props.images
    return <div class="form-group">
      {this.thumbnails(state.images)}
    </div>
  }
}
