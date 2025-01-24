<script setup>
import Menubar from 'primevue/menubar';

import {ref} from "vue";

const items = ref([
  {
    label: 'Home',
    icon: 'pi pi-home',
    url: '/'
  },
  {
    label: 'Products',
    icon: 'pi pi-apple',
    items: [
      {
        label: 'List Products',
        icon: 'pi pi-table',
        url: '/products'
      },
      {
        label: 'Create New',
        icon: 'pi pi-plus',
        url: '/products/create'
      },
    ]
  },
  {
    label: 'Categories',
    icon: 'pi pi-percentage',
    items: [
      {
        label: 'List Categories',
        icon: 'pi pi-table',
        url: '/categories'
      },
      {
        label: 'Create New',
        icon: 'pi pi-plus',
        url: '/categories/create'
      },
    ]
  },
  {
    label: 'Purchases',
    icon: 'pi pi-dollar',
    items: [
      {
        label: 'List Purchases',
        icon: 'pi pi-table',
        url: '/purchases'
      },
      {
        label: 'Create New',
        icon: 'pi pi-plus',
        url: '/purchases/create'
      },
    ]
  },
  {
    label: 'Suppliers',
    icon: 'pi pi-users',
    items: [
      {
        label: 'List Suppliers',
        icon: 'pi pi-table',
        url: '/suppliers'
      },
      {
        label: 'Create New',
        icon: 'pi pi-plus',
        url: '/suppliers/create'
      },
    ]
  },
  {
    label: 'Ledgers',
    icon: 'pi pi-book',
    items: [
      {
        label: 'List Ledgers',
        icon: 'pi pi-table',
        url: '/ledgers'
      },
      {
        label: 'Create New',
        icon: 'pi pi-plus',
        url: '/ledgers/create'
      },
    ]
  },
]);
</script>

<template>
  <div class="card">
    <Menubar :model="items"/>
  </div>
</template>

<style scoped>

</style>