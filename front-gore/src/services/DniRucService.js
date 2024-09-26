import { dni, api } from "src/boot/axios";

class DniRucService {
  static async dni(dni) {
    return await dniruc.get("v2/reniec/dni", {
      params: {
        numero: dni,
      },
    });
  }
  static async getPersonaDni(dni) {
    return (await api.get(`/api/personas/dni/${dni}`)).data;
  }
  static async getEmpresaRuc(ruc) {
    return (await api.get(`/api/personas/ruc/${ruc}`)).data;
  }
}

export default DniRucService;
