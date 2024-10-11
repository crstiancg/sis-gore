import { api } from "src/boot/axios";

class CartaService {
    static async getData(params) {
        return (await api.get('/api/cartas',params)).data;
    }

    static async get(id) {
        return (await api.get(`/api/cartas/${id}`)).data;
    }

    static async delete(id) {
        return (await api.delete(`/api/cartas/${id}`));
    }

    static async save(reg) {
        if (reg.id === undefined || reg.id === null) {
            return (await api.post("/api/cartas", reg)).data;
        } else {
            return (await api.put(`/api/cartas/${reg.id}`, reg)).data;
        }
    }

    static async getDatac(params) {
        return (await api.get('/api/cartasv',params)).data;
    }


}

export default CartaService;
