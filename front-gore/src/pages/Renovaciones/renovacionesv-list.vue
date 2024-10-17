<template>
  <div class="q-pa-md q-gutter-sm">
    <q-breadcrumbs>
      <q-breadcrumbs-el icon="home" />

      <q-breadcrumbs-el
        label="Renovaciones de Cartas Por Center"
        icon="mdi-key"
      />
    </q-breadcrumbs>
  </div>
  <q-separator />

  <div class="q-pa-sm col-12">
    <q-card bordered v-for="form in form" :key="form.id" class="q-mb-md">
      <q-card-section>
        <q-chip size="16px" icon="bookmark">Monto: S/. {{ form.monto }}</q-chip>
        <div class="q-ml-md text-subtitle2">
          Contratista: {{ form.contratista }}
        </div>
        <div class="q-ml-md text-body2 text-weight-bold">
          Denominacion: {{ form.denominacion }}
        </div>
        <div class="q-ml-md text-subtitle2">
          Meta: [ {{ form.meta.codmeta }} ] {{ form.meta.desmeta }}
        </div>
        <div class="q-ml-md text-subtitle2">
          Procedimiento: {{ form.procedimiento.desprocedim }}
        </div>
        <q-markup-table class="q-pa-md" flat dense>
          <thead>
            <tr>
              <th class="text-left">N°</th>
              <th class="text-left">Año</th>
              <th class="text-left">Tipo</th>
              <th class="text-center">N° llegada</th>
              <th class="text-left">Oficio Notificado</th>
              <th class="text-left">Oficio Efectivacion</th>
              <th class="text-left">Estado</th>
              <th class="text-left">Fecha Emisión</th>
              <th class="text-left">Fecha Vencimiento</th>
              <th class="text-left">E. Financiera</th>
              <!-- <th class="text-left">Dias por Vencer</th>
                  <th class="text-right">Acciones</th> -->
            </tr>
          </thead>
          <!-- {{ form.renovacions }} -->
          <tbody>
            <tr v-for="(a, i) in form.renovacions" :key="i">
              <td>{{ i + 1 }}</td>
              <td>{{ a.anio ? a.anio : "N/A" }}</td>
              <td>{{ a.tipo ? a.tipo : "N/A" }}</td>
              <td class="text-center">
                {{ a.numero_llegada ? a.numero_llegada : "N/A" }}
              </td>
              <td>{{ a.oficio_notificado ? a.oficio_notificado : "N/A" }}</td>
              <td>
                {{ a.oficio_efectivacion ? a.oficio_efectivacion : "N/A" }}
              </td>
              <td>
                <q-chip>{{ a.estado_carta ? a.estado_carta : "N/A" }}</q-chip>
              </td>
              <td>
                <q-chip color="positive" text-color="white">{{
                  a.fecha_incial ? a.fecha_incial : "N/A"
                }}</q-chip>
              </td>
              <td>
                <q-chip color="red" text-color="white">{{
                  a.fecha_vencimiento ? a.fecha_vencimiento : "N/A"
                }}</q-chip>
              </td>
              <td>{{ a.entidad.nombre ? a.entidad.nombre : "N/A" }}</td>
              <!-- <td>
                    <q-chip :color="daysRemaining[i] <= 6 ? 'red' : 'primary'" text-color="white">
                      {{ daysRemaining[i] !== null ? daysRemaining[i] + ' días restantes' : 'Fecha inválida' }}
                    </q-chip>
                  </td>
                  <td class="text-right">
                    <q-btn size="sm" @click="renovacion(a.id)" round color="primary" icon="edit"></q-btn>
                  </td> -->
            </tr>
          </tbody>
        </q-markup-table>
      </q-card-section>
    </q-card>
  </div>
  <pre>
        {{ form }}
      </pre
  >
</template>

<script setup>
import { ref, onMounted } from "vue";
import RenovacionService from "src/services/RenovacionService";
import CartaService from "src/services/CartaService";
import { useQuasar } from "quasar";
const $q = useQuasar();

const tableRef = ref();
const rows = ref([]);
const filter = ref("");
const loading = ref(false);
const form = ref([]);
const pagination = ref({
  sortBy: "id",
  descending: false,
  page: 1,
  rowsPerPage: 7,
  rowsNumber: 10,
});

async function onRequest(props) {
  const { page, rowsPerPage, sortBy, descending } = props.pagination;
  const filter = props.filter;
  loading.value = true;

  const fetchCount = rowsPerPage === 0 ? 0 : rowsPerPage;
  const order_by = descending ? "-" + sortBy : sortBy;
  const { data, total = 0 } = await RenovacionService.getData({
    params: { rowsPerPage: fetchCount, page, search: filter, order_by },
  });
  console.log(data);
  rows.value.splice(0, rows.value.length, ...data);
  !total
    ? (pagination.value.rowsNumber = data.length)
    : (pagination.value.rowsNumber = total);
  pagination.value.page = page;
  pagination.value.rowsPerPage = rowsPerPage;
  pagination.value.sortBy = sortBy;
  pagination.value.descending = descending;
  loading.value = false;
}

onMounted(() => {
  onRequestc();
});

async function onRequestc(params) {
  const row = await CartaService.getDatac();
  form.value = row;
  console.log(row);
}
</script>

<style scoped>
.my-card {
  width: 100%;
  max-width: 80vw;
}
</style>
