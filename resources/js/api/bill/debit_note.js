import axios from 'axios'

export default {
    getNotes(id, params) {
        return axios.get(`/debit-note/get-notes/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    storeNote(data) {
        return axios.post(`/debit-note/store-note`, data)
    },
    updateNote(id, data) {
        return axios.post(`/debit-note/update-note/${id}`, data)
    },
    deleteNote(id) {
        return axios.post(`/debit-note/delete-note/${id}`)
    }
}
