export default {
    getItems(params) {
        return axios.get(`/setting/get-material-items?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    getDescriptions(params) {
        return axios.get(`/setting/get-material-descriptions?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storeItem(data) {
        return axios.post('/setting/store-item', data)
    },
    updateItem(id, data) {
        return axios.post(`/setting/update-item/${id}`, data)
    },
    deleteItem(id) {
        return axios.post(`/setting/delete-item/${id}`);
    },
    storeDescription(data) {
        return axios.post('/setting/store-description', data)
    },
    updateDescription(id, data) {
        return axios.post(`/setting/update-description/${id}`, data)
    },
    deleteDescription(id) {
        return axios.post(`/setting/delete-description/${id}`);
    }
}