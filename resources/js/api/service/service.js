import axios from 'axios';
export default {
    getServices(params) {
        return axios.get(`/service/get-services?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storeService(data) {
        return axios.post('/service/store-service', data)
    },
    updateService(id, data) {
        return axios.post(`/service/update-service/${id}`, data)
    },
    deleteService(id) {
        return axios.post(`/service/delete-service/${id}`)
    },
    searchService(search) {
        return axios.get(`/service/search-service?search=${search}`)
    }
}
