import axios from 'axios'

export default {
    getMaintenanceType() {
        return axios.get('/truck-maintenance/get-types');
    },
    storeMaintenance(data) {
        return axios.post('/truck-maintenance/store-maintenance', data)
    },
    getHeavyEquipmentMaintenance(id, params) {
        return axios.get(`/truck-maintenance/get-truck-maintenance/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    deleteMaintenance(id) {
        return axios.post(`/truck-maintenance/delete-maintenance/${id}`)
    },
    updateMaintenance(id, data) {
        return axios.post(`/truck-maintenance/update-maintenance/${id}`, data);
    }
}
