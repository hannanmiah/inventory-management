<script setup>
import {Head} from '@inertiajs/vue3';
import NavBar from "@/Components/NavBar.vue";
import Toast from "primevue/toast";
import ConfirmDialog from "primevue/confirmdialog";

const {title} = defineProps({
  title: {
    type: String,
    default: 'Inventory Management'
  }
})
</script>

<template>
  <Head :title="title"/>
  <div
      class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 h-screen flex flex-col space-y-2 sm:space-y-4 md:space-y-6 lg:space-y-8">
    <NavBar/>
    <main class="px-4 md:px-8 flex flex-col space-y-4 md:space-y-8">
      <slot/>
    </main>
  </div>
  <Toast/>
  <ConfirmDialog></ConfirmDialog>
</template>

<style scoped>

</style>