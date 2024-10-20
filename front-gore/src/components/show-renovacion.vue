<template>
    <q-dialog v-model="formPapeletas" persistent>
      <RenovacionForm
      :title="title"
      :edit="edit"
      :id="editId"
      ref="renovacionformRef"
       @saveRenovacion="saveRenovacion"
      ></RenovacionForm>
    </q-dialog>
 <div class="q-px-md q-py-md">
    <div class="row justify-between">
        <div>
            <span class="text-h4 text-weight-bold">Historial de Renovaciones</span>
            <div class="row q-mb-xs">
                <q-breadcrumbs>
                    <q-breadcrumbs-el label="Historial de Renovaciones" icon="list" to="/cartas" />
                    <q-breadcrumbs-el :label="stringid" icon="visibility" />
                </q-breadcrumbs>
            </div>
        </div>
        <div>
            <!-- <q-btn v-if="!periodoCerrado" color="negative" label="Eliminar" @click="eliminar(props.periodoId)"
                class="q-mr-sm" /> -->
            <q-btn color="primary" label="Regresar" icon-right="filter_list"  @click="$router.push('/cartas')"/>
        </div>
    </div>
    
    <div class="q-pa-sm col-12"> 
        <q-card  bordered>
          <q-card-section>
            <q-chip size="16px" icon="bookmark">Monto: S/. {{form.monto}}</q-chip>  
            <div class="q-ml-md text-subtitle2">Contratista: {{ form.contratista }}  </div>
            <div class="q-ml-md text-body2 text-weight-bold">Denominacion: {{ form.denominacion }}  </div>
            <div class="q-ml-md text-subtitle2">Meta: [ {{ form.meta?.codmeta }} ] {{ form.meta?.desmeta }}  </div>
            <div class="q-ml-md text-subtitle2">Procedimiento:  {{ form.procedimiento?.desprocedim }}  </div>
            <q-markup-table  class="q-pa-md" flat dense>
              <thead>
                <tr>
                  <th class="text-left">N°</th>
                  <th class="text-left">Año</th>
                  <th class="text-left">Tipo</th>
                  <th class="text-center">N° llegada </th>
                  <th class="text-left">Oficio Notificado</th>
                  <th class="text-left">Oficio Efectivacion</th>
                  <th class="text-left">Estado</th>
                  <th class="text-left">Fecha Emisión</th>
                  <th class="text-left">Fecha Vencimiento</th>
                  <th class="text-left">E. Financiera</th>
                  <th class="text-left">Dias por Vencer</th>
                  <th class="text-right">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(a, i) in form.renovacions" :key="i">
                  <td>{{ i + 1 }}</td>
                  <td>{{ a.anio ? a.anio : 'N/A' }}</td>
                  <td>{{ a.tipo ? a.tipo : 'N/A' }}</td>
                  <td class="text-center">{{ a.numero_llegada ? a.numero_llegada : 'N/A' }}</td>
                  <td>{{ a.oficio_notificado ? a.oficio_notificado : 'N/A' }}</td>
                  <td>{{ a.oficio_efectivacion ? a.oficio_efectivacion : 'N/A' }}</td>
                  <td><q-chip>{{ a.estado_carta ? a.estado_carta : 'N/A' }}</q-chip></td>
                  <td><q-chip color="positive" text-color="white">{{ a.fecha_incial ? a.fecha_incial  : 'N/A' }}</q-chip></td>
                  <td><q-chip color="red" text-color="white">{{ a.fecha_vencimiento ? a.fecha_vencimiento  : 'N/A' }}</q-chip></td>
                  <td>{{ a.entidad.nombre ? a.entidad.nombre  : 'N/A' }}</td>
                  <td>
                    <q-chip :color="daysRemaining[i] <= 6 ? 'red' : 'primary'" text-color="white">
                      {{ daysRemaining[i] !== null ? daysRemaining[i] + ' días restantes' : 'Fecha inválida' }}
                    </q-chip>
                  </td>
                  <td class="text-right">
                    <q-btn size="sm" @click="renovacion(a.id)" round color="primary" icon="edit"></q-btn>
                  </td>
                </tr>
              </tbody>
            </q-markup-table>
          </q-card-section>
        </q-card>
      </div>
</div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import CartaService from "src/services/CartaService";
import { useQuasar } from "quasar";
import RenovacionForm from "src/pages/Cartas/renovacion-form.vue";
import RenovacionService from "src/services/RenovacionService";
import { useRoute, useRouter } from "vue-router";
import dayjs from 'dayjs';
const route = useRoute();
const $q = useQuasar();
const stringid = ref();
const daysRemaining = ref([]);
const renovacionformRef = ref();
const title = ref("");
const edit = ref(false);
const editId = ref();
const formPapeletas = ref(false);
const form = ref({
  meta:{},
  procedimiento:{},
  renovacions: [],
});

async function OnloadData() {
  try {
    const res = await CartaService.get(route.params.id);
    form.value = res;
    
    form.value.renovacions.forEach((a, index) => {
      if (a.fecha_incial && a.fecha_vencimiento) {
        const startDate = dayjs(a.fecha_incial);
        const endDate = dayjs(a.fecha_vencimiento);
        daysRemaining.value[index] = endDate.diff(startDate, 'day'); // Calcula los días restantes
      } else {
        daysRemaining.value[index] = null; // Si alguna de las fechas es inválida
      }
    });
  } catch (error) {
    console.error("Error al cargar datos:", error);
  }
}

// onMounted(async () =>{
//     console.log(route);
//     const res = await CartaService.get(route.params.id);
//     console.log(res);
//     form.value = res;

//     form.value.renovacions.forEach((a, index) => {
//     if (a.fecha_incial && a.fecha_vencimiento) {
//       const startDate = dayjs(a.fecha_incial);
//       const endDate = dayjs(a.fecha_vencimiento);
//       daysRemaining.value[index] = endDate.diff(startDate, 'day'); 
//     } else {
//       daysRemaining.value[index] = null; 
//     }
//   });
// })

onMounted(() => {
  OnloadData();
});


async function renovacion(id) {
      title.value = "Editar Renovacion";
      formPapeletas.value = true;
      edit.value = true;
      editId.value = id;
      console.log(editId.value);
      const row2 = await CartaService.get(id);
      const row = await RenovacionService.get(id);
      console.log(row);
  
      renovacionformRef.value.form.setData({...row, ...row2});
    }

const saveRenovacion = () => {
    formPapeletas.value = false;
    // tableRef.value.requestServerInteraction();
    $q.notify({
      type: "positive",
      message: "Guardado con Exito.",
      position: "top-right",
      progress: true,
      timeout: 1000,
    });

     OnloadData();
  };

</script>

<style scoped>
.my-card{
    width: 100%;
    max-width: 100vw;
  }
</style>