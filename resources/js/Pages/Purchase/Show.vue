<script setup>
import Card from 'primevue/card'
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import {ref} from 'vue'
import Breadcrumb from "primevue/breadcrumb";
import {useDateFormat} from "@vueuse/core";

const {purchase} = defineProps({
  purchase: {
    type: Object,
    required: true
  }
})

const items = ref([
  {label: 'Purchases', url: '/purchases'},
  {label: purchase.data.id}
])
</script>

<template>
  <DefaultLayout title="Purchase View">
    <Breadcrumb :home="{icon: 'pi pi-home',url: '/'}" :model="items"/>
    <Card>
      <template #title>
        <div class="flex flex-col gap-2">
          <h1>Supplier name: {{ purchase.data.supplier.name }}</h1>
          <h2>Total: ${{ purchase.data.total_amount }}</h2>
          <span>Date: {{ useDateFormat(purchase.data.created_at, 'YYYY-MM-DD') }}</span>
        </div>
      </template>
      <template #content>
        <DataTable :value="purchase.data.purchase_items">
          <Column field="product.name" header="Product Name"/>
          <Column field="quantity" header="Quantity"/>
          <Column field="unit_price" header="Unit Price"/>
          <Column field="total_price" header="Total Price"/>
        </DataTable>
      </template>
    </Card>
  </DefaultLayout>
</template>

<style scoped>

</style>