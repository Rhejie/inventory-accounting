import axios from "axios";

export default {
    getFixedAssets(params) {
        return axios.get(`fixed-assets/get-fixed-assets?page=${params.current_page}&count=${params.current_size}&search=${params.search}&type=${params.type}`);
    }
}
