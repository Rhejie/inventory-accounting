import axios from 'axios';

export default {
    getProposals(params) {
        return axios.get(`/proposal/get-proposals?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storeProposal(data) {
        return axios.post('/proposal/store-proposal', data)
    },
    updateProposal(id, data) {
        return axios.post(`/proposal/update-proposal/${id}`, data)
    },
    deleteProposal(id) {
        return axios.post(`/proposal/delete-proposal/${id}`)
    },
    getProposalNumber() {
        return axios.get(`/proposal/get-proposal-number`);
    },
    findProposal(id) {
        return axios.get(`/proposal/find-proposal/${id}`)
    },
    convertToInvoice(id) {
        return axios.post(`/proposal/conver-to-invoice/${id}`)
    },
    sendProposal(id) {
        return axios.post(`/proposal/send-proposal/${id}`)
    },
    changeStatus(id, value){
        return axios.post(`/proposal/change-status/${id}?status=${value}`)
    }
}
