<template>
  <q-dialog v-model="formPermisos" persistent>
    <CartasForm
      :title="title"
      :edit="edit"
      :id="editId"
      ref="personasformRef"
      @save="save"
    ></CartasForm>
  </q-dialog>
  <q-dialog v-model="formPapeletas" persistent>
    <RenovacionForm
      :title="title"
      :edit="edit"
      :id="editId"
      ref="renovacionformRef"
      @saveRenovacion="saveRenovacion"
    ></RenovacionForm>
  </q-dialog>
  <q-page>
    <div class="q-pa-md q-gutter-sm">
      <q-breadcrumbs>
        <q-breadcrumbs-el icon="home" />

        <q-breadcrumbs-el label="Cartas Fianza" icon="mdi-key" />
      </q-breadcrumbs>
    </div>
    <q-separator />
    <div class="q-gutter-xs q-pa-sm">
      <q-btn
        color="primary"
        :disable="loading"
        :label="$q.screen.lt.sm ? '' : 'Agregar'"
        icon-right="add"
        @click="
          {
            formPermisos = true;
            edit = false;
            title = 'Añadir Carta';
          }
        "
      />
    </div>

    <q-table
      :rows-per-page-options="[7, 10, 15]"
      class="my-sticky-header-table htable q-ma-sm"
      ref="tableRef"
      :rows="rows"
      :columns="columns"
      row-key="id"
      v-model:pagination="pagination"
      :loading="loading"
      :filter="filter"
      binary-state-sort
      @request="onRequest"
    >
      <template v-slot:top-right>
        <q-input
          active-class="text-white"
          standout="bg-primary"
          color="white"
          dense
          debounce="500"
          v-model="filter"
          placeholder="Buscar"
        >
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th v-for="col in props.cols" :key="col.name" :props="props">
            {{ col.label }}
          </q-th>
          <q-th auto-width> ACCIONES </q-th>
        </q-tr>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td v-for="col in props.cols" :key="col.name" :props="props">
            {{ col.value }}
          </q-td>
          <q-td auto-width>
            <q-btn
              size="sm"
              color="primary"
              round
              @click="editar(props.row.id)"
              icon="edit"
              class="q-mr-xs"
            />
            <q-btn
              size="sm"
              color="primary"
              round
              @click="renovacion(props.row.id)"
              icon="sync_problem"
              class="q-mr-xs"
            />
            <q-btn
              size="sm"
              color="primary"
              round
              @click="show_renovacion(props.row.id)"
              icon="filter_list"
              class="q-mr-xs"
            />
            <q-btn
              size="sm"
              color="primary"
              round
              @click="eliminar(props.row.id)"
              icon="delete"
            />
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from "vue";
import CartaService from "src/services/CartaService";
import { useQuasar } from "quasar";
import CartasForm from "src/pages/Cartas/cartas-form.vue";
import RenovacionForm from "src/pages/Cartas/renovacion-form.vue";
import { useRouter, useRoute } from "vue-router";
const router = useRouter();
const $q = useQuasar();
const columns = [
  {
    name: "id",
    label: "Id",
    aling: "center",
    field: (row) => row.id,
    sortable: true,
  },
  {
    name: "monto",
    label: "Monto Carta",
    aling: "center",
    field: (row) => row.monto,
    sortable: true,
  },
  {
    name: "idprocedim",
    label: "Procedimineto",
    aling: "center",
    field: (row) => row.procedimiento?.desprocedim,
    sortable: true,
  },
  {
    name: "idmeta",
    label: "Meta",
    aling: "center",
    field: (row) => row.meta?.codmeta,
    sortable: true,
  },
  {
    name: "contratista",
    label: "Contratista",
    aling: "center",
    field: (row) => row.contratista,
    sortable: true,
  },
  {
    name: "dependencia",
    label: "Dependencia",
    aling: "center",
    field: (row) => row.dependencia,
    sortable: true,
  },
  {
    name: "denominacion",
    label: "Denominacion",
    aling: "center",
    field: (row) => row.denominacion,
    sortable: true,
  },
];

const tableRef = ref();
const formPermisos = ref(false);
const formPapeletas = ref(false);
const personasformRef = ref();
const renovacionformRef = ref();
const title = ref("");
const edit = ref(false);
const editId = ref();
const rows = ref([]);
const filter = ref("");
const loading = ref(false);
const pagination = ref({
  sortBy: "id",
  descending: false,
  page: 1,
  rowsPerPage: 10,
  rowsNumber: 15,
});

async function onRequest(props) {
  const { page, rowsPerPage, sortBy, descending } = props.pagination;
  const filter = props.filter;
  loading.value = true;

  const fetchCount = rowsPerPage === 0 ? 0 : rowsPerPage;
  const order_by = descending ? "-" + sortBy : sortBy;
  const { data, total = 0 } = await CartaService.getData({
    params: { rowsPerPage: fetchCount, page, search: filter, order_by },
  });
  console.log(data);
  // clear out existing data and add new
  rows.value.splice(0, rows.value.length, ...data);
  // don't forget to update local pagination object
  !total
    ? (pagination.value.rowsNumber = data.length)
    : (pagination.value.rowsNumber = total);
  pagination.value.page = page;
  pagination.value.rowsPerPage = rowsPerPage;
  pagination.value.sortBy = sortBy;
  pagination.value.descending = descending;
  // ...and turn of loading indicator
  loading.value = false;
}

onMounted(() => {
  tableRef.value.requestServerInteraction();
});

const save = () => {
  formPermisos.value = false;
  tableRef.value.requestServerInteraction();
  $q.notify({
    type: "positive",
    message: "Guardado con Exito.",
    position: "top-right",
    progress: true,
    timeout: 1000,
  });
};
async function editar(id) {
  title.value = "Editar Carta Fianza ";
  formPermisos.value = true;
  edit.value = true;
  editId.value = id;
  const row = await CartaService.get(id);
  console.log(row);

  personasformRef.value.form.setData({ ...row });
  personasformRef.value.form.meta_id = row.meta.idmeta;
  personasformRef.value.form.procedimiento_id = row.procedimiento.idprocedim;
}

async function renovacion(id) {
  title.value = "Registrar Renovacion";
  formPapeletas.value = true;
  edit.value = false;
  editId.value = id;
  console.log(editId.value);
  const row = await CartaService.get(id);
  console.log(row);

  renovacionformRef.value.form.setData({ ...row });
}

const saveRenovacion = () => {
  formPapeletas.value = false;
  tableRef.value.requestServerInteraction();
  $q.notify({
    type: "positive",
    message: "Guardado con Exito.",
    position: "top-right",
    progress: true,
    timeout: 1000,
  });
};

async function show_renovacion(id) {
  console.log("show", id);
  router.push({
    name: "Renovacion",
    params: { id: id },
  });
}

async function eliminar(id) {
  $q.dialog({
    title: "¿Estas seguro de eliminar este registro?",
    message: "Este proceso es irreversible.",
    cancel: true,
    persistent: true,
  }).onOk(async () => {
    await CartaService.delete(id);
    tableRef.value.requestServerInteraction();
    $q.notify({
      type: "positive",
      message: "Eliminado con Exito.",
      position: "top-right",
      progress: true,
      timeout: 1000,
    });
  });
}
</script>
