import axios from 'axios';

export default {
    getSuppliers(params) {
        return axios.get(`/supplier-management/get-suppliers?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    storeSupplier(data) {
        return axios.post('/supplier-management/store-supplier', data);
    },
    getSupplierDetails(id) {
        return axios.get(`/supplier-management/get-supplier/${id}`);
    },
    updateSupplier(id, data) {
        return axios.post(`/supplier-management/update-supplier/${id}`, data);
    },
    deleteSupplier(id) {
        return axios.post(`/supplier-management/delete-supplier/${id}`);
    }
}
