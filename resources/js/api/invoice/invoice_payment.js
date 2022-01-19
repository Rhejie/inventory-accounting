import axios from 'axios'

export default {
    getPayments(id, params) {
        return axios.get(`/invoice-payment/get-payments/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storePayment(data) {
        return axios.post(`/invoice-payment/store-payment`, data)
    },
    updatePayment(id, data) {
        return axios.post(`/invoice-payment/update-payment/${id}`, data)
    },
    deletePayment(id) {
        return axios.post(`/invoice-payment/delete-payment/${id}`)
    }
}
