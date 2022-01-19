import axios from 'axios';

export default {
    storeProject(data) {
        return axios.post("projects/store-project", data);
    },
    getProject(params) {
        return axios.get(`projects/get-projects?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    deleteProject(id) {
        return axios.post(`/projects/delete-project/${id}`);
    },
    updateProject(id, data) {
        return axios.post(`projects/update-project/${id}`, data);
    },
    getProjectDetails(id) {
        return axios.get(`projects/project-details/${id}`)
    },
    storeProjectDocument(data, id) {
        return axios.post(`projects/store-project-document/${id}`, data);
    },
    getProjectDocuments(id, params) {
        return axios.get(`projects/get-project-documents/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    deleteDocument(id) {
        return axios.post(`/projects/delete-project-document/${id}`);
    },
    updateProjectDocument(data, id) {
        return axios.post(`/projects/update-project-document/${id}`, data);
    },
    getPorjectsData(search) {
        return axios.get(`/projects/get-project-data?search=${search}`);
    },
    fixedAssets(params, id) {
        return axios.get(`projects/get-fixed-assets/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    ConsumableSupplies(params, id) {
        return axios.get(`projects/get-consumable-supplies/${id}?page=${params.current_page}&count=${params.current_size}&search=${params.search}`);
    },
    ProjectFixedAsset(params) {
        return axios.post('projects/store-project-fixed-assets', params)
    },
    deleteProjectFixedAsset(params) {
        return axios.post('projects/delete-project-fixed-assets', params)
    },
    getBillOfMaterials(id) {
        return axios.get(`/bill-of-material/bill-of-materials/${id}`);
    },
    getBillOfMaterialItems() {
        return axios.get(`/bill-of-material/get-items-data`);
    },
    getDescriptions(search) {
        return axios.get(`/bill-of-material/get-description-data?search=${search}`)
    },
    storeMaterials(data) {
        return axios.post('/bill-of-material/store-bill-of-material', data);
    },
    deleteMaterial(id) {
        return axios.post(`/bill-of-material/delete-bill-of-material/${id}`)
    },
    updateBillOfMaterials(id, data) {
        return axios.post(`/bill-of-material/update-bill-of-material-project/${id}`, data)
    }
}
