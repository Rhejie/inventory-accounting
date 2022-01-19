import axios from 'axios';

export default {
    getConsumableItems(id, params) {
        return axios.get(`/consumable-items/get-consumable-items/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    storeConsumableItem(id, data) {
        return axios.post(`/consumable-items/store-consumable-item/${id}`, data);
    },
    updateConsumableItem(id, data) {
        return axios.post(`/consumable-items/update-consumable-item/${id}`, data);
    },
    deleteConsumableItem(id) {
        return axios.post(`/consumable-items/delete-consumable-item/${id}`);
    },
    geConsumableItemsInventory(params) {
        return axios.get(`/consumable-items/get-consumable-items-inventory?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },

    // consumable supply

    getSupply(params) {
        return axios.get(`/consumable-supply/get-consumable-supplies?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    storeSupply(data) {
        return axios.post(`/consumable-supply/store-supply`, data);
    },
    updateSupply(id, data) {
        return axios.post(`/consumable-supply/update-supply/${id}`, data);
    },
    deleteSupply(id) {
        return axios.post(`/consumable-supply/delete-supply/${id}`);
    },

    checkItem(params) {
        return axios.get(`/consumable-items/check-per-item?supplier_id=${params.supplier_id}&consumable_item=${params.consumable_item}`, )
    }
}
