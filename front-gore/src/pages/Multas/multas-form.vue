<template>
    <!-- content -->
    <q-card class="my-card">
      <q-card-section class="bg-primary text-white">
        <div class="text-h6">{{ title }}</div>
      </q-card-section>
      <q-form @submit.prevent="submit">
        <q-card-section class="q-pa-md">
          <div class="row">
            <div class="col-6">
              <q-input dense outlined class="col" v-model="form.nombre" :loading="form.validating" label="Falta *" @change="form.validate('nombre')" :error="form.invalid('nombre')" :class="form.invalid('nombre') ? 'q-mb-sm' : ''" >
                <template v-slot:prepend> <q-icon name="mdi-key" /> </template>
                <template v-slot:error><div> {{ form.errors.nombre }} </div></template>
              </q-input>
              <q-select dense outlined class="col" v-model="form.calificacion" :loading="form.validating" label="Seleccionar calificación *" :options="['Muy Grave', 'Grave', 'Leve']" @change="form.validate('calificacion')" :error="form.invalid('calificacion')" :class="form.invalid('calificacion') ? 'q-mb-sm' : ''" >
                <template v-slot:prepend> <q-icon name="mdi-key" /> </template>
                <template v-slot:error><div> {{ form.errors.calificacion }} </div></template>
              </q-select>
              <q-input dense outlined class="col" v-model="form.sancion" :loading="form.validating" label="Sanción *" @change="form.validate('sancion')" :error="form.invalid('sancion')" :class="form.invalid('sancion') ? 'q-mb-sm' : ''" >
                <template v-slot:prepend> <q-icon name="mdi-key" /> </template>
                <template v-slot:error><div> {{ form.errors.sancion }} </div></template>
              </q-input>
            </div>
            <q-input type="textarea" rows="8"  dense outlined class="col q-ml-md"  color="red-12" v-model="form.descripcion" :loading="form.validating" label="Infracción *" @change="form.validate('descripcion')" :error="form.invalid('descripcion')" :class="form.invalid('descripcion') ? 'q-mb-sm' : ''" >
              <template v-slot:prepend> <q-icon name="mdi-key" /> </template>
              <template v-slot:error><div> {{ form.errors.descripcion }} </div></template>
            </q-input>
          </div>
          <div class="row">
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
  import { onMounted, ref } from "vue";
  // import RoleService from "src/services/RoleService"
  // const isPwd = ref(true);
  // const roles = ref(false);
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
    form = useForm("put", "api/tipos/" + props.id, {
      id: "",
      nombre: "",
      descripcion: "",
      calificacion: "",
      sancion: "",
    });
  } else {
    form = useForm("post", "api/tipos", {
      id: "",
      nombre: "",
      descripcion: "",
      calificacion: "",
      sancion: "",
    });
  }

  const submit = () => {
    form
      .submit()
      .then((response) => {
        form.reset();
        // form.setData()
  
        emits("save");
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
  </script>
  <style scoped>
  .my-card{
    width: 100%;
    max-width: 80vw;
  }
  </style>
  