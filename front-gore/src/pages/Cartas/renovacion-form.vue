<template>
  <!-- content -->
  <q-card class="my-card">
    <q-card-section class="bg-primary text-white">
      <div class="text-h6">{{ title }} - Monto <q-chip size="lg" square color="positive" text-color="white" icon="assured_workload" :label="form.monto" />
        <div class="text-subtitle1">Carta Fianza - N° {{ props.id }} </div>
        <div class="text-subtitle2">Contratista: {{ form.contratista }}  </div>
        <div class="text-body2 text-weight-bold">Denominacion: {{ form.denominacion }}  </div>
      </div>
    </q-card-section>
    <q-form @submit.prevent="submit">
      <q-card-section class="q-pa-md">
        <div class="row q-mt-md">
          <q-input class="col q-mr-md" dense outlined v-model="form.numero_llegada" :loading="form.validating" label="Número de Llegada *" @change="form.validate('numero_llegada')" :error="form.invalid('numero_llegada')" :class="form.invalid('numero_llegada') ? 'q-mb-sm' : ''" >
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.numero_llegada }} </div> </template>
          </q-input>
          <q-select class="col" clearable dense outlined v-model="form.tipo" :loading="form.validating" label="Tipo de Carta *" @change="form.validate('tipo')" :options="['FIEL CUMPLIMIENTO','ADELANTO DIRECTO','ADELANTO DE MATERIALES']" :error="form.invalid('tipo')" :class="form.invalid('tipo') ? 'q-mb-sm' : ''" >
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.tipo }} </div> </template>
          </q-select>
          <q-input class="col q-ml-md" dense outlined v-model="form.fecha_incial" type="date" :loading="form.validating" label="Fecha de Emisión *" @change="form.validate('fecha_incial')" :error="form.invalid('fecha_incial')" :class="form.invalid('fecha_incial') ? 'q-mb-sm' : ''" >
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.fecha_incial }} </div> </template>
          </q-input>
          <q-input class="col q-ml-md" dense outlined v-model="form.fecha_vencimiento" type="date" :loading="form.validating" label="Fecha de Vencimiento *" @change="form.validate('fecha_vencimiento')" :error="form.invalid('fecha_vencimiento')" :class="form.invalid('fecha_vencimiento') ? 'q-mb-sm' : ''" >
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.fecha_vencimiento }} </div> </template>
          </q-input>
        </div>
        <div class="row q-mt-md">
          <q-input class="col q-mr-md" dense outlined v-model="form.numero_carta" :loading="form.validating" label="Numero de Carta *" @change="form.validate('numero_carta')" :error="form.invalid('numero_carta')" :class="form.invalid('numero_carta') ? 'q-mb-sm' : ''" >
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.numero_carta }} </div> </template>
          </q-input>
          <q-input class="col q-mr-md" dense outlined v-model="form.folios" :loading="form.validating" label="Numero de Folios *" @change="form.validate('folios')" :error="form.invalid('folios')" :class="form.invalid('folios') ? 'q-mb-sm' : ''" >
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.folios }} </div> </template>
          </q-input>
          <q-input class="col q-mr-md" dense outlined v-model="form.oficio_notificado" :loading="form.validating" label="Oficio Notificado *" @change="form.validate('oficio_notificado')" :error="form.invalid('oficio_notificado')" :class="form.invalid('oficio_notificado') ? 'q-mb-sm' : ''" >
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.oficio_notificado }} </div> </template>
          </q-input>
        </div>
        <div class="row q-mt-sm">
          <q-input class="col q-mr-md" dense outlined v-model="form.oficio_efectivizacion" :loading="form.validating" label="Oficio de Efectivacion *" @change="form.validate('oficio_efectivizacion')" :error="form.invalid('oficio_efectivizacion')" :class="form.invalid('oficio_efectivizacion') ? 'q-mb-sm' : ''" >
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.oficio_efectivizacion }} </div> </template>
          </q-input>
          <q-select class="col" clearable dense outlined v-model="form.estado_carta" :loading="form.validating" label="Estado de la Carta *" @change="form.validate('estado_carta')" :options="['RENOVADO','VENCIDO','DEVUELTO','PARA DEVOLVER','VIGENTE']" :error="form.invalid('estado_carta')" :class="form.invalid('estado_carta') ? 'q-mb-sm' : ''" >
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.estado_carta }} </div> </template>
          </q-select>
        </div>
        <!-- <q-file clearable dense outlined v-model="form.archivo" :loading="form.validating" label="archivo *"  @update:model-value="previewFile" @change="form.validate('archivo')" :error="form.invalid('archivo')" :class="form.invalid('archivo') ? 'q-mb-sm' : ''" >
          <template v-slot:prepend><q-icon name="mdi-key" /></template>
          <template v-slot:error> <div> {{ form.errors.archivo }} </div> </template>
        </q-file> -->
        
          <!-- <iframe v-if="fileUrl && form.archivo"
            :src="fileUrl"
            width="100%"
            height="500px"
          ></iframe> -->
      </q-card-section>
      <q-separator />

      <q-card-actions align="right">
        <q-btn label="Cancelar" flat v-close-popup></q-btn>
        <q-btn label="Guardar" :loading="form.processing" type="submit" color="positive" ></q-btn>
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script setup>
import { useForm } from "laravel-precognition-vue";
import { onMounted, ref } from "vue";
import SelectInput from "src/components/SelectInput.vue";
import InputAnio from "src/components/InputAnio.vue";
import EntidadService from "src/services/EntidadService"
const fileUrl = ref(null);
const emits = defineEmits(["saveRenovacion"]);
const props = defineProps({
  title: String,
  id: Number,
  edit: {
    type: Boolean,
    default: false,
  },
});

let form;
  if (props.edit) {
      form = useForm("put", "api/renovacion/" + props.id, {
        id: "",
        carta_id: props.id,
        anio: "",
        tipo: "",
        numero_llegada: "",
        fecha_incial: "",
        fecha_vencimiento: "",
        numero_carta: "",
        folios: "",
        oficio_notificado: "",
        tipo_proceso: "",
        oficio_efectivizacion: "",
        estado_carta: "",
        entidad_id: "",
    });
  } else {
  form = useForm("post", "api/renovacion", {
    id: "",
    carta_id: props.id,
    anio: "",
    tipo: "",
    numero_llegada: "",
    fecha_incial: "",
    fecha_vencimiento: "",
    numero_carta: "",
    folios: "",
    oficio_notificado: "",
    tipo_proceso: "",
    oficio_efectivizacion: "",
    estado_carta: "",
    entidad_id: "",
  });
}
const submit = () => {
  form
    .submit()
    .then((response) => {
      form.reset();
      // form.setData()

      emits("saveRenovacion");
    })
    .catch((error) => {
      // alert("An error occurred.");
    });
};

onMounted(() => {
  // setData();
  console.log(props.edit);
  // cargar();
  // console.log(form);
});

defineExpose({
  // setData,
  form,
});

const previewFile = () => {
  console.log("hola", form.archivo);
  if (form?.archivo) {
    fileUrl.value = URL.createObjectURL(form.archivo); // Generamos la URL temporal del archivo
  }
};
</script>
<style scoped>
.my-card{
  width: 100%;
  max-width: 80vw;
}
</style>
