<template>

 <q-img
      src="images/image6.jpg"
      alt=""
      style="
        height: 100%;
        width: 100%;
        object-fit: cover;
        position: fixed;
        z-index: -2;
      "
    >
     <div class="absolute-full text-subtitle1 text-center">
        </div>
    </q-img>
  
  <q-page padding class="row justify-center">
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 self-center text-center">
      <q-card class="q-pa-xs" style="border-start-start-radius: 30px; border-bottom-right-radius: 30px;">
        <q-img src="images/inicio_login.jpg" :fit="cover">
          <div class="absolute-top text-h5 flex flex-center">
            <div class="text-weight-bold">SIS GORE</div>
          </div>
        </q-img>
        <LoginForm @logued="onLogued"></LoginForm>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
import LoginForm from "pages/Auth/LoginForm.vue";
import { useRouter } from "vue-router";

const router = useRouter();
import { ref } from "vue";

const lorem = ref(
  "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
);

const onLogued = (e) => {
  router.push({ name: "Dash" });
};
</script>
<style lang="sass" scoped>
.my-card
  width: 100%
  max-width: 400px

.responsive
  display: flex
  justify-content: center
  align-items: center
</style>
