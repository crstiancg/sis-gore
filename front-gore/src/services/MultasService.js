import { api } from "src/boot/axios";

class MultasService {
    static async getData(params) {
        return (await api.get('/api/tipos',params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/tipos/${id}`)).data;
    }

    static async delete(id) {
        return (await api.delete(`/api/tipos/${id}`));
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await api.post("/api/tipos", reg)).data;
        } else {
            return (await api.put(`/api/tipos/${reg.id}`, reg)).data;
        }
    }
}

export default MultasService;
