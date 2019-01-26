import { h, Component } from 'preact';
import Close from '../components/Close'

export default class Thumbnail extends Component {
  constructor() {
    super()
    this.state.clickHandler = () => {}
    this.state.removeHandle = false
    this.state.hover = false
    this.state.image
  }

  hoverOn() {
    this.setState({
      hover: true,
    })
  }

  hoverOff() {
    this.setState({
      hover: false,
    })
  }

  closeButton() {
    return this.state.removeHandle ? <Close hover={this.state.hover} clickHandler={this.state.removeHandle} image={this.state.image}></Close> : <div></div>
  }

  render(props, state) {
    if (props.clickHandler) state.clickHandler = props.clickHandler
    if (props.removeHandle) state.removeHandle = props.removeHandle

    state.image = props.image

    return <div class={`image-thumbnail col-md-${props.size || 3}`} data-id={props.image.id}>
      <a class="thumbnail" style={styles.wrapper} onClick={() => this.state.clickHandler(props.image)} onMouseEnter={this.hoverOn.bind(this)} onMouseLeave={this.hoverOff.bind(this)}>
        {this.closeButton()}
        <img src={props.image.thumbnail_url} />
      </a>
    </div>
  }
}

const styles = {
  wrapper: {
    position: 'relative',
  }
}
