import axios from 'axios';

export default {
    getJobOrderType() {
        return axios.get('/other-job-order/get-types');
    },
    storeJobOrder(data) {
        return axios.post('/other-job-order/store-job-order', data)
    },
    getHeavyEquipmentJobOrders(id, params) {
        return axios.get(`/other-job-order/get-other-job-orders/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    deleteJobOrder(id) {
        return axios.post(`/other-job-order/delete-job-order/${id}`)
    },
    updateJobOrder(id, data) {
        return axios.post(`/other-job-order/update-job-order/${id}`, data);
    }
}
