import { h, Component } from 'preact';
import Axios from 'axios';

export default class Uploader extends Component {
  constructor() {
    super()
    this.state.uploadCallback = () => { }
    this.state.csrfToken = document.querySelector('[name="csrf-token"]').content
    this.refs = {}
  }

  onDrop(acceptedFiles, rejectedFiles) {
    console.log('Accepted files: ', acceptedFiles);
    console.log('Rejected files: ', rejectedFiles);
  }

  handleFiles(e) {
    let files = e.target.files
    console.log(files)
    Array.from(files)
      .forEach(file => this.upload(file)
      .then(response => response.data)
      .then(data => {
        this.state.uploadCallback(data)
        this.refs.fileInput.value = null
      })
      .catch(error => console.log(error)))
  }

  upload(file) {
    let formData = new FormData;
    formData.append('Files[file_name]', file)
    return Axios.post('/filemanager/files/upload', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'X-CSRF-Token': this.state.csrfToken,
        Accept: 'application/json',
      }
    })
  }

  render(props, state) {
    if (props.uploadCallback) state.uploadCallback = props.uploadCallback
    return (<div>
      <input type="file" ref={el => this.refs.fileInput = el} onChange={this.handleFiles.bind(this)} multiple="multiple" />
    </div>)
  }
}
