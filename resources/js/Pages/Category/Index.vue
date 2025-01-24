<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Card from "primevue/card";

const {categories} = defineProps({
  categories: {
    type: Object,
    required: true,
  }
})
</script>

<template>
  <DefaultLayout title="Home">
    <Card>
      <template #title>
        <h1>Categories</h1>
      </template>
      <template #content>
        <DataTable :value="categories.data" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]">
          <Column field="id" header="ID"/>
          <Column field="name" header="Name"/>
          <Column field="products_count" header="Total Products"/>
          <Column field="created_at" header="Created At"/>
        </DataTable>
      </template>
    </Card>
  </DefaultLayout>
</template>

<style scoped>

</style>