import axios from 'axios';

export default {
    getJobOrderType() {
        return axios.get('/heavy-job-order/get-types');
    },
    storeJobOrder(data) {
        return axios.post('/heavy-job-order/store-job-order', data)
    },
    getHeavyEquipmentJobOrders(id, params) {
        return axios.get(`/heavy-job-order/get-heavy-job-orders/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    deleteJobOrder(id) {
        return axios.post(`/heavy-job-order/delete-job-order/${id}`)
    },
    updateJobOrder(id, data) {
        return axios.post(`/heavy-job-order/update-job-order/${id}`, data);
    }
}
