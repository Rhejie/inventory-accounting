import axios from 'axios'

export default {
    getMaintenanceType() {
        return axios.get('/other-maintenance/get-types');
    },
    storeMaintenance(data) {
        return axios.post('/other-maintenance/store-maintenance', data)
    },
    getHeavyEquipmentMaintenance(id, params) {
        return axios.get(`/other-maintenance/get-other-maintenance/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    deleteMaintenance(id) {
        return axios.post(`/other-maintenance/delete-maintenance/${id}`)
    },
    updateMaintenance(id, data) {
        return axios.post(`/other-maintenance/update-maintenance/${id}`, data);
    }
}
