import createStore from 'unistore'
import Axios from 'axios'

export const Store = createStore({
  images: [],
  selected: [],
  selectedIds: [],
  page: 1,
  term: '',
  pageCount: 10,
  showSelector: false,
})

export const Actions = store => ({

  /**
   * @param {State} state
   * @param {Page} page
   */
  async getPage(state, page = 1) {
    let params = { page }
    if (state.term !== '') params["FilesSearch[title]"] = state.term

    let response = await Axios.get('/filemanager/files/index', {
      params,
      headers: {
        Accept: 'application/json'
      }
    })
    let data = await response.data
    return {
      images: state.images.push(data.images),
      page: page,
      pageCount: data.pageCount
    }
  }


})
