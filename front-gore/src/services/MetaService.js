import { api } from "src/boot/axios";

class MetaService {
  static async getData(params) {
    return (await api.get("/api/meta", params)).data;
  }

}

export default MetaService;
