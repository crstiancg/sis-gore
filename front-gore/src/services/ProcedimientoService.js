import { api } from "src/boot/axios";

class ProcedimientoService {
  static async getData(params) {
    return (await api.get("/api/procedimientos", params)).data;
  }

}

export default ProcedimientoService;
