import axios from 'axios'

export default {
    getAccounts(params) {
        return axios.get(`/bank-account/get-accounts?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storeAccount(data) {
        return axios.post(`/bank-account/store-account`, data)
    },
    updateAccount(id, data) {
        return axios.post(`/bank-account/update-account/${id}`, data)
    },
    deleteAccount(id) {
        return axios.post(`/bank-account/delete-account/${id}`)
    },
    searchAccount(search) {
        return axios.get(`/bank-account/search-account?search=${search}`)
    },

    getTransfers(params) {
        return axios.get(`/bank-account/get-transfers?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storeTransfer(data) {
        return axios.post(`/bank-account/store-transfer`, data)
    },
    updateTransfer(id, data) {
        return axios.post(`/bank-account/update-transfer/${id}`, data)
    },
    deleteTransfer(id) {
        return axios.post(`/bank-account/delete-transfer/${id}`)
    },
}
