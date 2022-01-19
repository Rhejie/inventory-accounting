import axios from 'axios';

export default {
    getInvoices(params) {
        return axios.get(`/invoice/get-invoices?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storeInvoice(data) {
        return axios.post('/invoice/store-invoice', data)
    },
    updateInvoice(id, data) {
        return axios.post(`/invoice/update-invoice/${id}`, data)
    },
    deleteInvoice(id) {
        return axios.post(`/invoice/delete-invoice/${id}`)
    },
    getInvoiceNumber() {
        return axios.get(`/invoice/get-invoice-number`);
    },
    findInvoice(id) {
        return axios.get(`/invoice/find-invoice/${id}`)
    },
    searchInvoice(search) {
        return axios.get(`/invoice/search-invoice?search=${search}`)
    },
    getCreditNotes(id, params) {
        return axios.get(`/invoice/get-credits/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    sendInvoice(id) {
        return axios.post(`/invoice/send-invoice/${id}`)
    }
}
