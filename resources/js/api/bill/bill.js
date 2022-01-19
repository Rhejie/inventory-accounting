import axios from 'axios'

export default {
    getBills(params) {
        return axios.get(`/bill/get-bills?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    storeBill(data) {
        return axios.post(`/bill/store-bill`, data);
    },
    updateBill(id, data) {
        return axios.post(`/bill/update-bill/${id}`, data)
    },
    deleteBill(id) {
        return axios.post(`/bill/delete-bill/${id}`)
    },
    getNumber() {
        return axios.get(`/bill/get-number`)
    },
    viewBill(id) {
        return axios.get(`/bill/view-bill/${id}`)
    },
    getBillItems(id) {
        return axios.get(`/bill/get-items/${id}`)
    },
    sendBill(id) {
        return axios.post(`/bill/send-bill/${id}`)
    },
    searchBill(search) {
        return axios.get(`/bill/search-bill?search=${search}`)
    },
    getPurchaseOrdersByBillUpdate(id) {
        return axios.get(`/bill/get-orders/${id}`)
    }
}
