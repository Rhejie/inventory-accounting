import axios from 'axios';

export default {
    getCategories(params) {
        return axios.get(`/category-inventory/get-category-inventory?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    updateCategory(id, data) {
        return axios.post(`/category-inventory/update-category-inventory/${id}`, data);
    },
    deleteCategory(id) {
        return axios.post(`/category-inventory/delete-category-inventory/${id}`);
    },
    getTypes() {
        return axios.get('/category-inventory/get-types-value');
    },
    storeCategory(data) {
        return axios.post('/category-inventory/store-category-inventory', data);
    }
}
