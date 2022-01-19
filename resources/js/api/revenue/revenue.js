import axios from 'axios'

export default {
    getRevenues(params) {
        return axios.get(`/revenue/get-revenues?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storeRevenue(data) {
        return axios.post(`/revenue/store-revenue`, data)
    },
    updateRevenue(id, data) {
        return axios.post(`/revenue/update-revenue/${id}`, data)
    },
    deleteRevenue($id) {
        return axios.post(`/revenue/delete-revenue/${$id}`)
    }
}
