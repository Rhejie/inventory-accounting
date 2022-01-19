import axios from "axios";

export default {
    getSuppliers(query) {
        return axios.get(`/purchase-order/get-suppliers?search=${query}`);
    },
    storeOrder(data) {
        return axios.post('/purchase-order/store-order', data);
    },
    getOrders(params) {
        return axios.get(`/purchase-order/get-orders?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    updateOrder(id, data) {
        return axios.post(`/purchase-order/update-order/${id}`, data);
    },
    updateOrderInView(id, data) {
        return axios.post(`/purchase-order/update-order-in-view/${id}`, data);
    },
    deleteOrder(id) {
        return axios.post(`/purchase-order/delete-order/${id}`)
    },
    getPurchaseOrderData(id) {
        return axios.get(`/purchase-order/get-purchase-order/${id}`);
    },
    getOrderItems(id) {
        return axios.get(`/purchase-order/get-purchase-order-items/${id}`)
    },
    storeOrderItem(id, supplier_id, data) {
        return axios.post(`/purchase-order/store-order-item/${id}/${supplier_id}`, data);
    },
    updateOrderItem(id, data) {
        return axios.post(`/purchase-order/update-order-item/${id}`, data);
    },
    deleteOrderItem(id, po_id) {
        return axios.post(`/purchase-order/delete-order-item/${id}?po_id=${po_id}`);
    },
    getSupplierItems(id, search) {
        return axios.get(`/purchase-order/get-supplier-items/${id}?search=${search}`)
    },
    addVat(id, vat) {
        return axios.post(`/purchase-order/add-vat/${id}?vat=${vat}`)
    },
    addDiscount(id, discount) {
        return axios.post(`/purchase-order/add-discount/${id}?discount=${discount}`)
    },
    addOthers(id, others) {
        return axios.post(`/purchase-order/add-others/${id}?others=${others}`)
    },
    getTransactionsItems(id) {
        return axios.get(`/purchase-order/get-transactions/${id}`)
    },
    getNumber() {
        return axios.get('/purchase-order/get-number')
    },
    getPurchaseOrdersBySupplier(id) {
        return axios.get(`/purchase-order/get-purchase-orders/${id}`)
    },
    getPurchaseOrdersBySupplierUpdate(id){
        return axios.get(`/purchase-order/get-purchase-orders-update/${id}`)
    },
    getPurchaseOrderFormsToBill(search) {
        return axios.get(`/purchase-order/get-purchase-orders-by-number?search=${search}`)
    }
}
