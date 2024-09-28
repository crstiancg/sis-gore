import { api } from "src/boot/axios";

class RenovacionService {
    static async getData(params) {
        return (await api.get('/api/renovacion',params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/renovacion/${id}`)).data;
    }

    static async delete(id) {
        return (await api.delete(`/api/renovacion/${id}`));
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await api.post("/api/renovacion", reg)).data;
        } else {
            return (await api.put(`/api/renovacion/${reg.id}`, reg)).data;
        }
    }
}

export default RenovacionService;
