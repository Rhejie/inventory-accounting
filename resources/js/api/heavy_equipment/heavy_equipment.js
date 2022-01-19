import axios from 'axios';

export default {
    storeEquipement(data) {
        return axios.post('heavy-equipment/add-equipment', data);
    },
    getEquipments(params) {
        return axios.get(`heavy-equipment/get-equipments?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    getEquipmentInfo(id) {
        return axios.get(`heavy-equipment/get-equipment-info/${id}`);
    },
    storeEquipmentDocument(id, data) {
        return axios.post(`heavy-equipment/add-equipment-document/${id}`, data);
    },
    getEquipmentDocuments(id,params) {
        return axios.get(`heavy-equipment/get-equipment-documents/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    download(data) {
        return axios.get(`heavy-equipment/download-document/${data}`);
    },
    updateEquipment(id, data) {
        return axios.post(`heavy-equipment/update-equipment/${id}`, data);
    },
    updateEquipmentDocument(id, data) {
        return axios.post(`heavy-equipment/update-equipment-document/${id}`, data);
    },
    deleteDocument(id) {
        return axios.post(`heavy-equipment/delete-document/${id}`);
    },
    deleteHeavyEquipment(id) {
        return axios.post( `heavy-equipment/delete-equipment/${id}`);
    },
    getHistory(id, params) {
        return axios.get(`heavy-equipment/get-equipment-history/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    returnToWarehouse(data) {
        return axios.post('heavy-equipment/return-to-warehouse', data)
    }
}
