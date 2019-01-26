import { h, render } from 'preact'
import FilePicker from './views/FilePicker'
import { Store, Actions} from './store/FilePickerStore'
import { Provider, connect } from 'unistore/preact'
import 'react-dragula/dist/dragula.min.css';

var elements = document.querySelectorAll('*[data-filemanager]')

if (elements) {
  elements.forEach(function(element) {
    var view = element.getAttribute('data-filemanager')
    var target = element.getAttribute('data-target')
    var selected = element.getAttribute('data-selected')
    var limit = element.getAttribute('data-limit')
    switch (view) {
      case 'FilePicker':
        render(<Provider store={Store}>
          <FilePicker target={target} selected={selected} limit={limit} />
        </Provider> , element);
        break;
    }
  })
}
