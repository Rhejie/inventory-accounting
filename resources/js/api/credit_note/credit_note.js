import axios from 'axios';

export default {
    getCredits(params) {
        return axios.get(`/credit-note/get-credits?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storeCredit(data) {
        return axios.post(`/credit-note/store-credit`, data)
    },
    updateCredit(id, data) {
        return axios.post(`/credit-note/update-credit/${id}`, data)
    },
    deleteCredit(id) {
        return axios.post(`/credit-note/delete-credit/${id}`)
    }
}
