import axios from "axios";

export default {

    getReceived(params) {
        return axios.get(`/purchase-received/get-receives?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },

    getPurchaseOrderForms(search) {
        return axios.get(`/purchase-received/get-purchase-order-forms?search=${search}`);
    },

    getPurchaseOrderFormItem(id, search) {
        return axios.get(`/purchase-received/get-purchase-order-items/${id}?search=${search}`);
    },

    storePurchaseRecieved(data) {
        return axios.post('/purchase-received/store', data);
    },
    storeItem(data) {
        return axios.post('/purchase-received/storeItem', data);
    },
    updatePurchaseReceived(id, data) {
        return axios.post(`/purchase-received/update/${id}`, data);
    },
    deletePurchaseReceived(id) {
        return axios.post(`/purchase-received/delete/${id}`);
    },
    getPurchaseItems(po_form_id, po_form_item_id) {
        return axios.get(`/purchase-received/get-purchase-items/${po_form_id}?po_form_item_id=${po_form_item_id}`)
    },
    gtePurchaseOrder(id) {
        return axios.get(`/purchase-received/get-purchase-form/${id}`)
    },
    getHasSupply(project_id, consumable_item) {
        return axios.get(`/purchase-received/get-has-supply/${project_id}?consumable_item=${consumable_item}`)
    },
    getReceivedDetails(id) {
        return axios.get(`/purchase-received/get-received-details/${id}`)
    },
    getReceivedItems(id, params) {
        return axios.get(`/purchase-received/get-received-items/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`)
    },
    getItemReceivedQuantity(id) {
        return axios.get(`/purchase-received/get-item-received-quantity/${id}`);
    },
    getItemReceivedQuantityItem(id) {
        return axios.get(`/purchase-received/get-item-received-quantity-item/${id}`);
    }
}
