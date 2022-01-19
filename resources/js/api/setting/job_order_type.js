import axios from 'axios'

export default {
    store(data) {
        return axios.post('/setting/store-job-order', data)
    },
    update(id, data) {
        return axios.post(`/setting/update-job-order/${id}`, data)
    },
    delete(id) {
        return axios.post(`/setting/delete-job-order/${id}`)
    },
    getData(params) {
        return axios.get(`/setting/get-job-order?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    }
}
