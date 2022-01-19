import axios from 'axios';
export default {
    getTaxes(params) {
        return axios.get(`/constant/get-taxes?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storeTax(data) {
        return axios.post(`/constant/store-tax`, data)
    },
    updateTax(id, data) {
        return axios.post(`/constant/update-tax/${id}`, data)
    },
    deleteTax(id) {
        return axios.post(`/constant/delete-tax/${id}`)
    },
    searchTax(search) {
        return axios.get(`/constant/search-tax?search=${search}`)
    },

    getUnits(params) {
        return axios.get(`/constant/get-units?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    storeUnit(data) {
        return axios.post(`/constant/store-unit`, data)
    },
    updateUnit(id, data) {
        return axios.post(`/constant/update-unit/${id}`, data)
    },
    deleteUnit(id) {
        return axios.post(`/constant/delete-unit/${id}`)
    },
    searchUnit(search) {
        return axios.get(`/constant/search-units?search=${search}`)
    },
}
