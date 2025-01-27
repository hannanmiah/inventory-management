<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Card from "primevue/card";
import Breadcrumb from 'primevue/breadcrumb';
import {ref, reactive, computed} from 'vue'
import {useDateFormat} from "@vueuse/core";
import Button from "primevue/button";
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "primevue/usetoast";
import {router} from "@inertiajs/vue3";
import InputText from "primevue/inputtext";
import Select from "primevue/select";
import {watchDebounced} from "@vueuse/core";

const {products, categories} = defineProps({
  products: {
    type: Object,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
})

const filter = reactive({
  name: '',
  sku: '',
  category_id: '',
})

const filters = computed(() => {
  const result = {}
  Object.keys(filter).forEach(key => {
    result[`filter[${key}]`] = filter[key]
  })
  return result
})

watchDebounced(filter, () => {
  router.reload({
    data: filters.value
  })
}, {debounce: 500, maxWait: 500})

const resetFilters = () => {
  filter.name = ''
  filter.sku = ''
  filter.category_id = ''
}

const items = ref([
  {label: 'Products'},
]);

const confirm = useConfirm();
const toast = useToast();

function destroy(id) {
  confirm.require({
    message: 'Do you want to delete this record?',
    header: 'Confirmation',
    icon: 'pi pi-info-circle',
    rejectLabel: 'Cancel',
    rejectProps: {
      label: 'Cancel',
      severity: 'secondary',
      outlined: true
    },
    acceptProps: {
      label: 'Delete',
      severity: 'danger'
    },
    accept: () => {
      router.delete(route('products.destroy', id))
      toast.add({severity: 'info', summary: 'Confirmed', detail: 'Record deleted', life: 3000});
    },
    reject: () => {
      toast.add({severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000});
    }
  });
}
</script>

<template>
  <DefaultLayout title="Products">
    <Breadcrumb :home="{icon: 'pi pi-home', url: '/'}" :model="items"/>
    <Card>
      <template #title>
        <section class="flex space-x-2 md:space-x-4">
          <Button icon="pi pi-filter-slash" @click="resetFilters" severity="secondary"/>
          <InputText v-model="filter.name" placeholder="Filter By Name"/>
          <InputText v-model="filter.sku" placeholder="Filter By SKU"/>
          <Select v-model="filter.category_id" option-value="id" option-label="name" :options="categories"
                  placeholder="Filter By Category"/>
        </section>
      </template>
      <template #content>
        <DataTable :value="products.data" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]">
          <template #header>
            <section class="flex justify-between items-center">
              <h1 class="text-lg md:text-2xl font-medium md:font-bold">Products</h1>
              <Button as="Link" label="New" :href="route('products.create')" icon="pi pi-plus" class="mr-2"/>
            </section>
          </template>
          <Column field="id" header="ID"/>
          <Column field="name" header="Name"/>
          <Column field="sku" header="SKU"/>
          <Column field="category" header="Category">
            <template #body="slotProps">
              {{ slotProps.data.category.name }}
            </template>
          </Column>
          <Column field="price" header="Price"/>
          <Column field="initial_stock_quantity" header="Initial Stock"/>
          <Column field="current_stock_quantity" header="Current Stock"/>
          <Column field="created_at" header="Created At">
            <template #body="slotProps">
              {{ useDateFormat(slotProps.data.created_at, 'YYYY-MM-DD HH:mm:ss') }}
            </template>
          </Column>
          <Column header="Actions">
            <template #body="slotProps">
              <section class="inline-flex space-x-1">
                <Button as="Link" :href="route('products.show',slotProps.data.id)" severity="success"
                        variant="outlined" icon="pi pi-eye" rounded aria-label="View"/>
                <Button as="Link" :href="route('products.edit',slotProps.data.id)" severity="info"
                        variant="outlined" icon="pi pi-pencil" rounded aria-label="Edit"/>
                <Button @click="destroy(slotProps.data.id)" severity="danger" variant="outlined" icon="pi pi-trash"
                        rounded aria-label="Delete"/>
              </section>
            </template>
          </Column>
        </DataTable>
      </template>
      <template #footer> In total there are {{ products.data.length }} products.</template>
    </Card>
  </DefaultLayout>
</template>

<style scoped>

</style>