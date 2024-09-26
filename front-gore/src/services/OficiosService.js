import { api } from "src/boot/axios";

class OficiosService {
    static async getData(params) {
        return (await api.get('/api/oficios',params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/oficios/${id}`)).data;
    }

    static async delete(id) {
        return (await api.delete(`/api/oficios/${id}`));
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await api.post("/api/oficios", reg)).data;
        } else {
            return (await api.put(`/api/oficios/${reg.id}`, reg)).data;
        }
    }
}

export default OficiosService;
