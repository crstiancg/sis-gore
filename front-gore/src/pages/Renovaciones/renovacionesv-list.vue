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
  <div class="q-pb-md" style="max-width:280px">
    <div class="q-gutter-md">
      <q-select color="teal" stack-label options-selected-class="text-deep-orange" use-chips filled dense v-model="rform.fecha"  @update:model-value="onRequestc" :options="options" emit-value map-options label="Seleccione dia de vencimiento"></q-select>
    </div>
  </div>
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
          Meta: [ {{ form.meta?.codmeta }} ] {{ form.meta?.desmeta }}
        </div>
        <div class="q-ml-md text-subtitle2">
          Procedimiento: {{ form.procedimiento?.desprocedim }}
        </div>
        <q-markup-table class="q-pa-md" flat dense>
          <thead>
            <tr>
              <!-- <th class="text-left">N°</th> -->
              <th class="text-left">Año</th>
              <th class="text-left">Tipo</th>
              <!-- <th class="text-center">N° llegada</th> -->
              <th class="text-left">Oficio Notificado</th>
              <th class="text-left">Estado</th>
              <th class="text-left">Fecha Emisión</th>
              <th class="text-left">Fecha Vencimiento</th>
              <th class="text-left">E. Financiera</th>
              <th class="text-left">Dias por Vencer</th>
              <th class="text-left">Dias Pasando</th>
            </tr>
          </thead>
          <!-- {{ form.renovacions }} -->
          <tbody>
            <tr v-for="(a, i) in form.renovacions" :key="i">
              <!-- <td>{{ i + 1 }}</td> -->
              <td>{{ a.anio ? a.anio : "N/A" }}</td>
              <td>{{ a.tipo ? a.tipo : "N/A" }}</td>
              <!-- <td class="text-center">
                {{ a.numero_llegada ? a.numero_llegada : "N/A" }}
              </td> -->
              <td>{{ a.oficio_notificado ? a.oficio_notificado : "N/A" }}</td>
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
              <td>
                <q-chip :color="a.daysRemaining !== null && a.daysRemaining <= 6 ? 'red' : 'teal'" text-color="white">
                  {{ a.daysRemaining !== null ? a.daysRemaining + ' días restantes' : 'Vencido' }}
                </q-chip>
              </td>
             <td>
              <q-chip color="orange" text-color="white">
                {{ a.daysPassedSinceExpiration !== null ? a.daysPassedSinceExpiration + ' días pasados' : 'N/A' }}
              </q-chip>
            </td>
            </tr>
          </tbody>
        </q-markup-table>
      </q-card-section>
    </q-card>
  </div>
  <!-- <pre>{{ form }}</pre> -->
</template>

<script setup>
import { ref, onMounted } from "vue";
import RenovacionService from "src/services/RenovacionService";
import CartaService from "src/services/CartaService";
import { useQuasar } from "quasar";
import dayjs from 'dayjs';
const $q = useQuasar();

const loading = ref(false);
const form = ref({});
const daysRemaining = ref([]);

const options = ref([
{ label: 'A 1 DIA DE VENCER', value: 1 }, 
{ label: 'A 2 DIAS DE VENCER', value: 2 },
{ label: 'A 3 DIAS DE VENCER', value: 3 }, 
{ label: 'A 4 DIAS DE VENCER', value: 4},
{ label: 'A 5 DIAS DE VENCER', value: 5},
{ label: 'A 6 DIAS DE VENCER', value: 6},
])

const rform = ref({
  fecha: "",
});

onMounted(() => {
  onRequestc();
});

async function onRequestc(params) {
   try {
    const row = await CartaService.getDatac(rform.value);
    form.value = row;

    form.value.forEach(item => {
      if (!item.renovacions) {
        item.renovacions = [];
      }
    });

    // Limpiamos daysRemaining ya que ahora no lo utilizaremos
    daysRemaining.value = [];

    form.value.forEach(item => {
      item.renovacions.forEach(a => {
        if (a.fecha_incial && a.fecha_vencimiento) {
          const today = dayjs();
          const endDate = dayjs(a.fecha_vencimiento);

          // Calcular días restantes antes del vencimiento
          a.daysRemaining = endDate.diff(today, 'day');

          // Si ya pasó la fecha, calcular los días que han transcurrido desde el vencimiento
          if (a.daysRemaining < 0) {
            a.daysRemaining = null; // No mostrar días restantes si ya venció
          }

          // Calcular días desde que venció
          a.daysPassedSinceExpiration = today.diff(endDate, 'day');
        } else {
          a.daysRemaining = null;
          a.daysPassedSinceExpiration = null;
        }

      });
    });

    console.log("Datos procesados:", form.value);
  } catch (error) {
    console.error("Error al cargar datos:", error);
  }
}
</script>

<style scoped>
.my-card {
  width: 100%;
  max-width: 80vw;
}
</style>
