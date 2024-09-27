<template>
    <q-card class="my-card">
      <q-card-section class="bg-primary text-white">
         <div class="row">
    <div class="col-md-11 col">
      <div class="text-h6 text-weight-bold text-uppercase">{{ title }}
      </div>
    </div>
      <div class="q-ml-xl">  
        <q-btn v-close-popup round color="grey-4" >
          <q-icon name="close" color="black" />
        </q-btn>
      </div>
    </div>
      </q-card-section>
      <q-form @submit.prevent="submit">
        <q-card-section class="q-pa-md">
          <SelectInput  dense outlined clearable  label="Seleccionar Meta" color="teal" v-model="form.meta_id" :options="MetaService" OptionValue="idmeta" OptionLabel="label" :requerido="true"></SelectInput>
          <div class="row q-mt-md">
          <SelectInput  dense outlined class="col q-mr-md" clearable  label="Seleccionar Procedimiento" color="teal" v-model="form.procedimiento_id" :options="ProcedimientoService" OptionValue="idprocedim" OptionLabel="desprocedim" :requerido="true"></SelectInput>
          <q-input dense outlined class="col" v-model="form.monto" :loading="form.validating" label="Monto *" @change="form.validate('monto')" :error="form.invalid('monto')" :class="form.invalid('monto') ? 'q-mb-sm' : ''">
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.monto }} </div> </template>
          </q-input>
          <q-input dense outlined class="col q-ml-md" v-model="form.dependencia" :loading="form.validating" label="Dependencia *" @change="form.validate('dependencia')" :error="form.invalid('dependencia')" :class="form.invalid('dependencia') ? 'q-mb-sm' : ''">
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.dependencia }} </div> </template>
          </q-input>
          <q-input dense outlined class="col q-ml-md" v-model="form.contratista" :loading="form.validating" label="Contratista *" @change="form.validate('contratista')" :error="form.invalid('contratista')" :class="form.invalid('contratista') ? 'q-mb-sm' : ''">
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.contratista }} </div> </template>
          </q-input>
        </div>
        <div class="row">
          <q-input dense outlined class="col" v-model="form.denominacion" :loading="form.validating" label="Denominacion *" @change="form.validate('denominacion')" :error="form.invalid('denominacion')" :class="form.invalid('denominacion') ? 'q-mb-sm' : ''">
            <template v-slot:prepend><q-icon name="mdi-key" /></template>
            <template v-slot:error> <div> {{ form.errors.denominacion }} </div> </template>
          </q-input>
        </div>
        </q-card-section>
        <q-separator />
  
        <q-card-actions align="right">
          <q-btn label="Cancelar" flat v-close-popup></q-btn>
          <q-btn
            label="Guardar"
            :loading="form.processing"
            type="submit"
            color="positive"
          ></q-btn>
        </q-card-actions>
      </q-form>
    </q-card>
  </template>
  
  <script setup>
  import { useForm } from "laravel-precognition-vue";
  import { onMounted, computed, ref, watch } from "vue";
  import SelectInput from "src/components/SelectInput.vue";
  import MetaService from "src/services/MetaService";
  import ProcedimientoService from "src/services/ProcedimientoService";
  import { useQuasar } from "quasar";
  const $q = useQuasar();
  const emits = defineEmits(["save"]);
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
      form = useForm("put", "api/cartas/" + props.id, {
        id: "",
        monto: "",
        dependencia: "",
        contratista: "",
        denominacion: "",
        meta_id:"",
        procedimiento_id:"",
    });
  } else {
      form = useForm("post", "api/cartas", {
        id: "",
        monto: "",
        dependencia: "",
        contratista: "",
        denominacion: "",
        meta_id:"",
        procedimiento_id:"",
    });
  }




  const submit = () => {
      form
      .submit()
      .then((response) => {
        form.reset();
        // form.setData()
        console.log(response);
  
        emits("save");
      })
      .catch((error) => {
        const errorMessage =
        error.response && error.response.data && error.response.data.error
          ? error.response.data.error
          : "Error desconocido";

      // Mostrar notificación usando Quasar Framework
      $q.notify({
        position: "top",
        type: "negative",
        message: errorMessage,
      });
      });
  };
  

  onMounted(() => {
    // setData();
    console.log("hola...", props.edit);
    // cargar();
    // console.log(form);
  });
  
  defineExpose({
    // setData,
    form,
  });
  </script>
  <style scoped>
  .my-card{
    width: 100%;
    max-width: 80vw;
  }
  </style>
  