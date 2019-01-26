import { h, Component } from 'preact';
import Thumbnail from '../components/Thumbnail'
import Dragula from 'react-dragula'

export default class Selected extends Component {

  constructor() {
    super()
    this.state.images = []
    this.state.clickHandler = () => {}
  }

  render(props = { images: [] }, state) {
    if (props.clickHandler) state.clickHandler = props.clickHandler
    return <div class="close-btn" style={props.hover ? {...styles.close, ...styles.hover} : styles.close} onClick={() => state.clickHandler(props.image)}>
      X
    </div>
  }
}

const styles = {
  close: {
    position: 'absolute',
    top: '5px',
    right: '5px',
    color: '#ff0000',
    cursor: 'pointer',
    opacity: 0,
    'font-weight': 'bold',
    'text-decoration': 'none',
    transition: '500ms opacity'
  },
  hover: {
    opacity: 1
  }
}
