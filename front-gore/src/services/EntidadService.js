import { api } from "src/boot/axios";

class EntidadService {
    static async getData(params) {
        return (await api.get('/api/entidad',params)).data;
    }

    // static async get(id) {
    //     return (await api.get(`/api/entidad/${id}`)).data;
    // }

    // static async delete(id) {
    //     return (await api.delete(`/api/entidad/${id}`));
    // }

    // static async save(reg) {
    //     if (reg.id === undefined || reg.id === null) {
    //         return (await api.post("/api/entidad", reg)).data;
    //     } else {
    //         return (await api.put(`/api/entidad/${reg.id}`, reg)).data;
    //     }
    // }
}

export default EntidadService;
