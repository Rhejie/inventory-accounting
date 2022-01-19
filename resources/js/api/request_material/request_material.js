import axios from "axios";

export default {
    getRequest(params) {
        return axios.get(`/request-material/get-request?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    storeRequest(data) {
        return axios.post('/request-material/store-request', data);
    },
    updateRequest(id, data) {
        return axios.post(`/request-material/update-request/${id}`, data);
    },
    deleteRequest(id) {
        return axios.post(`/request-material/delete-request/${id}}`);
    },
    getProjects(project) {
        return axios.get(`/request-material/get-projects?project=${project}`);
    },
    getRequestDetails(id) {
        return axios.get(`/request-material/get-requested/${id}`);
    },
    getConsumableSupply(id, query) {
        return axios.get(`/request-material/get-consumable-supply/${id}?search=${query}`);
    },
    storeRequestConsumable(id, data) {
        return axios.post(`/request-material/store-request-material-consumable/${id}`, data);
    },
    updateRequestConsumable(id, data) {
        return axios.post(`/request-material/update-request-material-consumable/${id}`, data)
    },
    deleteConsumableSupply(id) {
        return axios.post(`/request-material/delete-request-consumable-supply/${id}`);
    },
    getRequestConsumable(id, params) {
        return axios.get(`/request-material/get-request-consumable/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    getFixedAsset(params) {
        return axios.get(`/request-material/get-fixed-assets?search=${params}`);
    },
    storeRequestMaterialFixedAsset(id, data) {
        return axios.post(`/request-material/store-request-fixed-asset/${id}`, data);
    },
    getRequestFixedAsset(id, params) {
        return axios.get(`/request-material/get-request-fixed-assets/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    updateRequestMaterialFixedAsset(id, data) {
        return axios.post(`/request-material/update-fixed-asset/${id}`, data)
    },
    deleteFixedAsset(id) {
        return axios.post(`/request-material/delete-request-fixed-asset/${id}`)
    },
    getRequestFixedAssetStockOut(request_form_from_project_id, search) {
        return axios.get(`/request-material/get-request-fixed-assets-stock-out?search=${search}&request_form_from_project_id=${request_form_from_project_id}`);
    },
    getRequestConsumableStockOut(request_form_from_project_id, search) {
        return axios.get(`/request-material/get-request-consumable-supplies-stock-out?search=${search}&request_form_from_project_id=${request_form_from_project_id}`);
    },
    getRequestProject(search) {
        return axios.get(`/request-material/get-request-project?search=${search}`);
    },
    getConsumableSuppliesData(params) {
        return axios.get(`/request-material/get-consumable-supplies-data?request_form_from_project=${params.request_form_from_project_id}`);
    },
    getRequestMaterialCodet(search) {
        return axios.get(`/request-material/get-request-rmcode?search=${search}`);
    },
    getNumber() {
        return axios.get('/request-material/get-number')
    }
}
