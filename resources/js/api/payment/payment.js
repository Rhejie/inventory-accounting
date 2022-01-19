import axios from 'axios'

export default {
    getPayments(params) {
        return axios.get(`/payment/get-payments?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storePayment(data) {
        return axios.post(`/payment/store-payment`, data)
    },
    updatePayment(id, data) {
        return axios.post(`/payment/update-payment/${id}`, data)
    },
    deletePayment(id) {
        return axios.post(`/payment/delete-payment/${id}`)
    }
}
