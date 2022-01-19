import axios from 'axios'

export default {
    getTrucksVehicles(params) {
        return axios.get(`truck-vehicle/get-trucks-vehicles?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    addTruckVehicle(data) {
        return axios.post(`truck-vehicle/add-truck-vehicle`, data);
    },
    getInfo(id) {
        return axios.get(`truck-vehicle/get-truck-vehicle-info/${id}`);
    },
    updateTruckVehicle(id, data) {
        return axios.post(`truck-vehicle/update-truck-vehicle/${id}`, data);
    },
    getDocuments(id, params) {
        return axios.get(`truck-vehicle/get-trucks-vehicles-documents/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    storeDocument(id, data) {
        return axios.post(`truck-vehicle/store-document/${id}`, data);
    },
    updateDocument(id, data) {
        return axios.post(`truck-vehicle/update-document/${id}`, data);
    },
    deleteDocument(id) {
        return axios.post(`truck-vehicle/delete-document/${id}`);
    },
    deleteTruckVehicle(id) {
        return axios.post(`truck-vehicle/delete-truck-vehicle/${id}`);
    },
    getHistory(id, params) {
        return axios.get(`truck-vehicle/get-truck-vehicle-history/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    }
}
