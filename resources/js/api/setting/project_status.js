import axios from 'axios'

export default {
    store(data) {
        return axios.post('/setting/store-project-status', data)
    },
    update(id, data) {
        return axios.post(`/setting/update-project-status/${id}`, data)
    },
    delete(id) {
        return axios.post(`/setting/delete-project-status/${id}`)
    },
    getData(params) {
        return axios.get(`/setting/get-project-status?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    }
}
