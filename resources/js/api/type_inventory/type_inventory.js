import axios from 'axios';

export default {
    getTypes(params) {
        return axios.get(`/type-inventory/get-types-inventory?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    updateType(id, data) {
        return axios.post(`/type-inventory/update-type-inventory/${id}`, data);
    },
    deleteType(id) {
        return axios.post(`/type-inventory/delete-type-inventory/${id}`);
    },
    storeType(data) {
        return axios.post(`/type-inventory/store-type-inventory`, data);
    }
}
