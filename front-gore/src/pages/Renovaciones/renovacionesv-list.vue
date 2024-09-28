<template>
    <q-page>
      <div class="q-pa-md q-gutter-sm">
        <q-breadcrumbs>
          <q-breadcrumbs-el icon="home" />
  
          <q-breadcrumbs-el label="Renovaciones de Cartas Por Center" icon="mdi-key" />
        </q-breadcrumbs>
      </div>
      <q-separator />
 
      <q-table
        :rows-per-page-options="[7, 10, 15]"
        class="my-sticky-header-table htable q-ma-sm"
        title="Lista de Renovaciones"
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
            <!-- <q-th auto-width> Acciones </q-th> -->
          </q-tr>
        </template>
  
        <template v-slot:body="props">
          <q-tr :props="props">
            <q-td v-for="col in props.cols" :key="col.name" :props="props">
              {{ col.value }}
            </q-td>
            <!-- <q-td auto-width>
              <q-btn
                size="sm"
                outline
                color="green"
                round
                @click="editar(props.row.id)"
                icon="edit"
                class="q-mr-xs"
              />
              <q-btn
                size="sm"
                outline
                color="red"
                round
                @click="eliminar(props.row.id)"
                icon="delete"
              />
            </q-td> -->
          </q-tr>
        </template>
      </q-table>
    </q-page>
  </template>
  
  <script setup>
  import { ref, onMounted } from "vue";
  import RenovacionService from "src/services/RenovacionService";
  import { useQuasar } from "quasar";
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
      name: "id",
      label: "Id",
      aling: "center",
      field: (row) => row.carta.procedimiento.desprocedim,
      sortable: true,
    },
  ];
  
  const tableRef = ref();
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
    tableRef.value.requestServerInteraction();
  });


  </script>
  
  