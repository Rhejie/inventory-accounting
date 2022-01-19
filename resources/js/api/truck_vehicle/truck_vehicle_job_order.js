import axios from 'axios';

export default {
    getJobOrderType() {
        return axios.get('/truck-job-order/get-types');
    },
    storeJobOrder(data) {
        return axios.post('/truck-job-order/store-job-order', data)
    },
    getHeavyEquipmentJobOrders(id, params) {
        return axios.get(`/truck-job-order/get-truck-job-orders/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    deleteJobOrder(id) {
        return axios.post(`/truck-job-order/delete-job-order/${id}`)
    },
    updateJobOrder(id, data) {
        return axios.post(`/truck-job-order/update-job-order/${id}`, data);
    }
}
