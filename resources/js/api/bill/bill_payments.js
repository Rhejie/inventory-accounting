import axios from 'axios'

export default {
    getPayments(id, params) {
        return axios.get(`/bill-payment/get-payments/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    storePayment(data) {
        return axios.post(`/bill-payment/store-payment`, data);
    },
    updatePayment(id, data) {
        return axios.post(`/bill-payment/update-payment/${id}`, data);
    },
    deletePayment(id) {
        return axios.post(`/bill-payment/delete-payment/${id}`)
    }
}
