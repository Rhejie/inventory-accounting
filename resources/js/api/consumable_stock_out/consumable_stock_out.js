import axios from 'axios'

export default {
    store(data) {
        return axios.post(`/supply-stock-out/store`, data);
    },
    getStockOut(params) {
        return axios.get(`/supply-stock-out/list?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    update(id, data) {
        return axios.post(`/supply-stock-out/update/${id}`, data)
    },
    delete(id, data) {
        return axios.post(`/supply-stock-out/delete/${id}`, data)
    },
    isDelivered(id, is_delivered) {
        return axios.post(`/supply-stock-out/is-delivered/${id}?is_delivered=${is_delivered}`)
    },
}
