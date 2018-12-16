import { h, Component } from 'preact';

export default class Pagination extends Component {

  constructor() {
    super()
    this.clickHandler = e => false
  }

  getFirstButton(page = 1) {
    if (page <= 1) {
      return <li class={'prev disabled'}><span>«</span></li>
    }
    return <li class={'prev'}><a onClick={() => this.clickHandler(page-1)}>«</a></li>
  }

  getLastButton(count, page = 1) {
    if (page + 1 >= count) {
      return <li class={'next disabled'}><span>»</span></li>
    }
    return <li class={'next'}><a onClick={() => this.clickHandler(page+1)}>»</a></li>
  }

  getOffset(page, count, limit) {
    let offset = page - Math.floor((limit-1) / 2)
    return offset >= 1 ? offset : 1
  }

  getNumbers(count, page = 1, limit = 11) {
    let nums = []
    let offset = this.getOffset(page, count, limit)
    let top = (offset + limit) > count ? count : offset + limit
    for (let i = offset; i <= top; i++) {
      nums.push(<li class={page == i ? 'active' : ''}><a style={styles.button} onClick={() => this.clickHandler(i)}>{i}</a></li>)
    }
    return nums
  }

  render(props) {
    if (props.clickHandler) this.clickHandler = props.clickHandler
    return <div>
      <ul class="pagination">
        {this.getFirstButton(props.page)}
        {this.getNumbers(props.pageCount, props.page)}
        {this.getLastButton(props.pageCount, props.page)}
      </ul>
    </div>
  }
}

const styles = {
  button: {
    textAlign: 'center',
    minWidth: '40px',
  }
}
