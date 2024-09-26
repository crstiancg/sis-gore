<template>
  <!-- content -->
  <q-card class="my-card">
    <q-card-section class="bg-primary text-white">
      <div class="text-h6">{{ title }} {{ props.id }}</div>
      <!-- <div class="text-subtitle2">Usuario</div> -->
    </q-card-section>
    <q-form @submit.prevent="submit">
      <q-card-section class="q-pa-md">
        <div class="row">
          <SelectInput class="col" dense outlined v-model="form.tipo_id" :options="TipoService" label="Seleccionar Infracción" clearable :requerido="true" OptionValue="id" OptionLabel="nombre"></SelectInput>
          <SelectInput class="col q-ml-md" dense outlined v-model="form.oficio_id" :options="OficiosService" label="Seleccionar Oficio" clearable :requerido="true" OptionValue="id" OptionLabel="nombre"></SelectInput>
        </div>
        <div class="row q-mt-md">
          <q-input class="col" dense outlined v-model="form.placa" :loading="form.validating" label="Placa *" @change="form.validate('placa')" :error="form.invalid('placa')" :class="form.invalid('placa') ? 'q-mb-sm' : ''" >
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.placa }} </div> </template>
          </q-input>
          <q-input class="col q-ml-md" dense outlined v-model="form.papeleta" :loading="form.validating" label="Papeleta *" @change="form.validate('papeleta')" :error="form.invalid('papeleta')" :class="form.invalid('papeleta') ? 'q-mb-sm' : ''" >
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.papeleta }} </div> </template>
          </q-input>
          <q-input class="col q-ml-md" dense outlined v-model="form.fecha" type="date" :loading="form.validating" label="Fecha *" @change="form.validate('fecha')" :error="form.invalid('fecha')" :class="form.invalid('fecha') ? 'q-mb-sm' : ''" >
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.fecha }} </div> </template>
          </q-input>
        </div>
        <q-input dense outlined v-model="form.observacion" :loading="form.validating" label="Observacion *" @change="form.validate('observacion')" :error="form.invalid('observacion')" :class="form.invalid('observacion') ? 'q-mb-sm' : ''" >
          <template v-slot:prepend><q-icon name="mdi-key" /></template>
          <template v-slot:error> <div> {{ form.errors.observacion }} </div> </template>
        </q-input>
        <q-file clearable dense outlined v-model="form.archivo" :loading="form.validating" label="archivo *"  @update:model-value="previewFile" @change="form.validate('archivo')" :error="form.invalid('archivo')" :class="form.invalid('archivo') ? 'q-mb-sm' : ''" >
          <template v-slot:prepend><q-icon name="mdi-key" /></template>
          <template v-slot:error> <div> {{ form.errors.archivo }} </div> </template>
        </q-file>
        
          <iframe v-if="fileUrl && form.archivo"
            :src="fileUrl"
            width="100%"
            height="500px"
          ></iframe>
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
import TipoService from "src/services/TipoService"
import OficiosService from "src/services/OficiosService"
// const isPwd = ref(true);
// const roles = ref(false);
const fileUrl = ref(null);
const emits = defineEmits(["savePapeleta"]);
const props = defineProps({
  title: String,
  id: Number,
  edit: {
    type: Boolean,
    default: false,
  },
});

let form;
// if (props.edit) {
//   form = useForm("put", "api/areas/" + props.id, {
//     id: "",
//     observacion: "",

//   });
// } else {
  form = useForm("post", "api/papeletas", {
    id: "",
    persona_id: props.id,
    observacion: "",
    tipo_id: null,
    archivo: null,
    fecha: "",
    papeleta: "",
    placa: "",
  });
// }

const submit = () => {
  form
    .submit()
    .then((response) => {
      form.reset();
      // form.setData()

      emits("savePapeleta");
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
