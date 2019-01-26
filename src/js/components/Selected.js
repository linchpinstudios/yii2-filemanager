import { h, Component } from 'preact';
import Thumbnail from '../components/Thumbnail'
import Dragula from 'react-dragula'

export default class Selected extends Component {

  constructor() {
    super()
    this.state.images = []
    this.state.clickHandler = false
    this.state.orderHandler = () => {}
    this.state.removeHandle = false
    this.dragulaDecorator = this.dragulaDecorator.bind(this);
    this.thumbnails = this.thumbnails.bind(this)
  }

  dragulaDecorator(componentBackingInstance) {
    if (componentBackingInstance) {
      let options = {
        drop: (el) => {
          console.log('dropped', el)
        }
      }
      let drake = Dragula([componentBackingInstance], options);
      drake.on('drop', (el, target, source, sibling) => {
        let order = []

        for (let i = 0; i < source.children.length; i++) {
          order.push(source.children[i].dataset.id)
        }

        this.state.orderHandler(order)
      })
    }
  }

  thumbnails(images) {
    let components = []
    images.forEach((image, key) => {
      components.push(<Thumbnail image={image} size="2" clickHandler={this.state.clickHandler} removeHandle={this.state.removeHandle} />)
    })
    return components
  }

  render(props = { images: [] }, state) {
    if (props.clickHandler) state.clickHandler = props.clickHandler
    if (props.removeHandle) state.removeHandle = props.removeHandle
    if (props.orderHandler) state.orderHandler = props.orderHandler
    state.images = props.images
    return <div class="form-group" ref={this.dragulaDecorator}>
      {this.thumbnails(state.images)}
    </div>
  }
}
