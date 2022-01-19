import axios from 'axios';

export default {
    getStockOut(params) {
        return axios.get(`/fixed-asset-stock-out/list?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    store(data) {
        return axios.post('/fixed-asset-stock-out/store', data);
    },
    isDelivered(id, is_delivered) {
        return axios.post(`/fixed-asset-stock-out/is-delivered/${id}?is_delivered=${is_delivered}`)
    },
    delete(id) {
        return axios.post(`/fixed-asset-stock-out/delete/${id}`)
    },
    update(id, data) {
        return axios.post(`/fixed-asset-stock-out/update/${id}`, data)
    }
}
