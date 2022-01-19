import axios from 'axios'

export default {
    getOtherInventoryData(params) {
        return axios.get(`/other-inventory/get-other-inventory?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    getInfo(id) {
        return axios.get(`/other-inventory/get-other-inventory-info/${id}`);
    },
    storeOtherInventory(data) {
        return axios.post('/other-inventory/add-other-inventory', data);
    },
    getDocuments(id, params) {
        return axios.get(`/other-inventory/get-documents/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    storeDocument(id, data) {
        return axios.post(`other-inventory/store-document/${id}`, data);
    },
    updateOtherInventory(id, data) {
        return axios.post(`/other-inventory/update-other-inventory/${id}`, data);
    },
    updateDocument(id, data) {
        return axios.post(`/other-inventory/update-document/${id}`,data);
    },
    deleteDocument(id) {
        return axios.post(`other-inventory/delete-document/${id}`);
    },
    deleteOtherInventory(id) {
        return axios.post( `/other-inventory/delete-other-inventory/${id}`);
    },
    getHistory(id, params) {
        return axios.get(`/other-inventory/get-other-inventory-history/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    }
}
