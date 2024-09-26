<template>
    <q-dialog v-model="formMultas" persistent>
      <MultasForm
        :title="title"
        :edit="edit"
        :id="editId"
        ref="multasformRef"
        @save="save"
      ></MultasForm>
    </q-dialog>
    <q-page>
      <div class="q-pa-md q-gutter-sm">
        <q-breadcrumbs>
          <q-breadcrumbs-el icon="home" />
  
          <q-breadcrumbs-el label="Tributos - Multas" icon="mdi-key" />
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
              formMultas = true;
              edit = false;
              title = 'Añadir Tributos / Multas';
            }
          "
        />
      </div>
  
      <q-table
        :rows-per-page-options="[7, 10, 15]"
        class="my-sticky-header-table htable q-ma-sm"
        title="Tributos - Multas"
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
            <q-th auto-width> Acciones </q-th>
          </q-tr>
        </template>
  
        <template v-slot:body="props">
          <q-tr :props="props">
            <q-td v-for="col in props.cols" :key="col.name" :props="props">
              <template v-if="col.name === 'calificacion'">
                <q-chip
                  :color="getChipColor(col.value)"
                  :text-color="getChipTextColor(col.value)"
                  icon="bookmark"
                >
                  {{ col.value }}
                </q-chip>
              </template>
              <template v-else>
                {{ col.value }}
              </template>
            </q-td>
            <q-td auto-width>
              <q-btn size="md" @click="editar(props.row.id)" icon="edit" class="q-mr-xs" />
              <q-btn size="md" @click="eliminar(props.row.id)" icon="delete" />
            </q-td>
          </q-tr>
        </template>
      </q-table>
    </q-page>
  </template>
  
  <script setup>
  import { ref, onMounted } from "vue";
  import MultasService from "src/services/MultasService";
  import { useQuasar } from "quasar";
  import MultasForm from "src/pages/Multas/multas-form.vue";
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
      name: "nombre",
      label: "Nombre",
      aling: "center",
      field: (row) => row.nombre,
      sortable: true,
    },
    {
      name: "calificacion",
      label: "Calificacion",
      aling: "center",
      field: (row) => row.calificacion,
      sortable: true,
    },
    {
      name: "sancion",
      label: "Sancion",
      aling: "center",
      field: (row) => row.sancion,
      sortable: true,
    },
  ];
  
  const tableRef = ref();
  const formMultas = ref(false);
  const multasformRef = ref();
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
    rowsPerPage: 7,
    rowsNumber: 10,
  });
  
  async function onRequest(props) {
    const { page, rowsPerPage, sortBy, descending } = props.pagination;
    const filter = props.filter;
    loading.value = true;
  
    const fetchCount = rowsPerPage === 0 ? 0 : rowsPerPage;
    const order_by = descending ? "-" + sortBy : sortBy;
    const { data, total = 0 } = await MultasService.getData({
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
    formMultas.value = false;
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
    title.value = "Editar Tributos - Multas ";
    formMultas.value = true;
    edit.value = true;
    editId.value = id;
    const row = await MultasService.get(id);
    console.log(row);
  
    multasformRef.value.form.setData(row);
  }
  
  async function eliminar(id) {
    $q.dialog({
      title: "¿Estas seguro de eliminar este registro?",
      message: "Este proceso es irreversible.",
      cancel: true,
      persistent: true,
    }).onOk(async () => {
      await MultasService.delete(id);
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

const getChipColor = (sancion) => {
  switch (sancion) {
    case 'Muy Grave':
      return 'red';
    case 'Grave':
      return 'yellow'; 
    case 'Leve':
      return 'grey'; 
    default:
      return 'grey'; 
  }
};

const getChipTextColor = (sancion) => {
  return sancion === 'Grave' ? 'black' : 'white'; 
};
  </script>
  
  