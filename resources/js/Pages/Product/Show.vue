<script setup>
import Card from 'primevue/card'
import {ref} from 'vue'
import Breadcrumb from "primevue/breadcrumb";
import {useDateFormat} from "@vueuse/core";

const {product} = defineProps({
  product: {
    type: Object,
    required: true
  }
})

const items = ref([
  {label: 'Products', url: '/products'},
  {label: product.data.id}
])
</script>

<template>
  <DefaultLayout title="Product View">
    <Breadcrumb :home="{icon: 'pi pi-home',url: '/'}" :model="items"/>
    <Card>
      <template #title>
        <h1 class="text-lg md:text-2xl font-bold">{{ product.data.name }}</h1>
      </template>
      <template #content>
        <ul class="flex flex-col gap-2">
          <li class="list">
            <strong>ID:</strong> {{ product.data.id }}
          </li>
          <li class="list">
            <strong>Price:</strong> ${{ product.data.price }}
          </li>
          <li class="list">
            <strong>Initial Stock:</strong> {{ product.data.initia_stock_quantity }}
          </li>
          <li class="list">
            <strong>Current Stock:</strong> {{ product.data.current_stock_quantity }}
          </li>
          <li class="list">
            <strong>Category:</strong> {{ product.data.category.name }}
          </li>
          <li class="list">
            <strong>Created At:</strong> {{ useDateFormat(product.data.created_at, 'YYYY-MM-DD HH:mm:ss') }}
          </li>
          <li class="list">
            <strong>Updated At:</strong> {{ useDateFormat(product.data.updated_at, 'YYYY-MM-DD HH:mm:ss') }}
          </li>
        </ul>
      </template>
    </Card>
  </DefaultLayout>
</template>

<style scoped>
.list {
  border-bottom: 1px solid #ddd;
  padding-bottom: 10px;
}
</style>