import axios from 'axios'

export default {
    getMaintenanceType() {
        return axios.get('/heavy-maintenance/get-types');
    },
    storeMaintenance(data) {
        return axios.post('/heavy-maintenance/store-maintenance', data)
    },
    getHeavyEquipmentMaintenance(id, params) {
        return axios.get(`/heavy-maintenance/get-heavy-maintenance/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    deleteMaintenance(id) {
        return axios.post(`/heavy-maintenance/delete-maintenance/${id}`)
    },
    updateMaintenance(id, data) {
        return axios.post(`/heavy-maintenance/update-maintenance/${id}`, data);
    }
}
