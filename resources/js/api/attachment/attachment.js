import axios from 'axios'

export default {
    getAttachments(params) {
        return axios.get(`/attachment/get-attachments?attachable_id=${params.attachable_id}&type=${params.type}`)
    },
    storeAttachment(data) {
        return axios.post(`/attachment/store-attachment`, data)
    },
    deleteAttachment(id, type) {
        return axios.post(`/attachment/delete-attachment/${id}?type=${type}`)
    }
}
