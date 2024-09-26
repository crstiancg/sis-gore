<template>
 <div class="q-px-md q-py-md">
    <div class="row justify-between">
        <div>
            <span class="text-h4 text-weight-bold">Historial de Papeletas</span>
            <div class="row q-mb-xs">
                <q-breadcrumbs>
                    <q-breadcrumbs-el label="Persona Natural / Persona Juridica" icon="list" to="/personas" />
                    <q-breadcrumbs-el :label="stringid" icon="visibility" />
                </q-breadcrumbs>
            </div>
        </div>
        <div>
            <!-- <q-btn v-if="!periodoCerrado" color="negative" label="Eliminar" @click="eliminar(props.periodoId)"
                class="q-mr-sm" /> -->
            <q-btn color="primary" label="Regresar" icon-right="filter_list"  @click="$router.push('/personas')"/>
        </div>
    </div>
    
    <div class="q-pa-sm col-12">
        <q-card  bordered>
          <q-card-section>
            <span>{{form.rsocial ? form.rsocial : form.nombre_completo}}</span>
            <q-markup-table  class="q-pa-md" flat dense>
              <thead>
                <tr>
                  <th class="text-left">N°</th>
                  <th class="text-left">Observacion</th>
                  <th class="text-left">Tipo de Infracción</th>
                  <th class="text-left">Calificacion</th>
                  <th class="text-left">Infracción</th>
                  <th class="text-right">Archivo</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(a, i) in form.papeletas" :key="i">
                  <td>{{ i + 1 }}</td>
                  <td>{{ a.observacion ? a.observacion : 'N/A' }}</td>
                  <td>{{ a.tipo.nombre ? a.tipo.nombre : 'N/A' }}</td>
                  <td>{{ a.tipo.calificacion ? a.tipo.calificacion  : 'N/A' }}</td>
                  <td>
                    <q-scroll-area style="height: 40px; max-width: 100%;">
                      <span>{{ a.tipo.descripcion  ? a.tipo.descripcion : 'N/A' }}</span>
                    </q-scroll-area>
                  </td>
                  <td style="white-space: normal;" class="text-right"><a v-if="a.archivo" :href="a.archivo" target="_blank" style="text-decoration:none; "> 
                      <q-chip clickable @click="onClick" color="primary" text-color="white" icon="picture_as_pdf"> {{ i + 1 }} Ver archivo</q-chip>
                  </a>
                    <span v-else>N/A</span>
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
import PersonaService from "src/services/PersonaService";
import { useQuasar } from "quasar";
import { useRoute, useRouter } from "vue-router";
const route = useRoute();
const stringid = ref();
const form = ref({
    personas: {
        papeletas: {
          tipo: {},
        },
    },
});

onMounted(async () =>{
    console.log(route);
    const res = await PersonaService.get(route.params.id);
    console.log(res);
    form.value = res;
})
</script>

<style scoped>
.my-card{
    width: 100%;
    max-width: 100vw;
  }
</style>