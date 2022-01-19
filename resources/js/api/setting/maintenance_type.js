import axios from 'axios'

export default {
    store(data) {
        return axios.post('/setting/store-maintenance-type', data)
    },
    update(id, data) {
        return axios.post(`/setting/update-maintenance-type/${id}`, data)
    },
    delete(id) {
        return axios.post(`/setting/delete-maintenance-type/${id}`)
    },
    getData(params) {
        return axios.get(`/setting/get-maintenance-type?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    }
}
