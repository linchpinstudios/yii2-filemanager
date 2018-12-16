import { h, Component } from 'preact';

export default class Thumbnail extends Component {

  constructor() {
    super()
    this.state.clickHandler = () => {}
  }

  render(props, state) {
    if (props.clickHandler) state.clickHandler = props.clickHandler
    return <div class={`image-thumbnail col-md-${props.size || 3}`}>
      <a class="thumbnail" onClick={() => state.clickHandler(props.image)}>
        <img src={props.image.thumbnail_url} />
      </a>
    </div>
  }

}
