<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Card from "primevue/card";
import Breadcrumb from 'primevue/breadcrumb';
import {computed, reactive, ref} from 'vue'
import {useDateFormat, watchDebounced} from "@vueuse/core";
import Button from "primevue/button";
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "primevue/usetoast";
import {router} from "@inertiajs/vue3";
import InputText from "primevue/inputtext";
import Select from "primevue/select";
import DatePicker from 'primevue/datepicker';

const {ledgers, suppliers} = defineProps({
  ledgers: {
    type: Object,
    required: true,
  },
  suppliers: {
    type: Array,
    required: true,
  },
})

const filter = reactive({
  balance: '',
  supplier_id: '',
})

const dates = ref([])

const filters = computed(() => {
  const result = {}
  Object.keys(filter).forEach(key => {
    result[`filter[${key}]`] = filter[key]
  })
  if (dates.value.length > 0) {
    // result['filter[transaction_between]'] = dates.value.join(',')
    result['filter[transaction_between]'] = dates.value.map(date => date ? useDateFormat(date, 'YYYY-MM-DD').value : '').join(',')
  }
  return result
})

watchDebounced([filter, dates], () => {
  router.reload({
    data: filters.value
  })
}, {debounce: 500, maxWait: 500})

const resetFilters = () => {
  filter.balance = ''
  filter.supplier_id = ''
  dates.value = ['', '']
}
const items = ref([
  {label: 'Ledgers'},
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
      router.delete(route('ledgers.destroy', id))
      toast.add({severity: 'info', summary: 'Confirmed', detail: 'Record deleted', life: 3000});
    },
    reject: () => {
      toast.add({severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000});
    }
  });
}
</script>

<template>
  <DefaultLayout title="Ledgers">
    <Breadcrumb :home="{icon: 'pi pi-home', url: '/'}" :model="items"/>
    <Card>
      <template #title>
        <section class="flex space-x-2 md:space-x-4">
          <Button icon="pi pi-filter-slash" @click="resetFilters" severity="secondary"/>
          <InputText v-model="filter.balance" type="number" placeholder="Filter with balance"/>
          <DatePicker v-model="dates" selectionMode="range" :manualInput="false" dateFormat="dd-mm-yy"
                      placeholder="select transaction date range"/>
          <Select v-model="filter.supplier_id" option-value="id" option-label="name" :options="suppliers"
                  placeholder="Filter By Supplier"/>
        </section>
      </template>
      <template #content>
        <DataTable :value="ledgers.data" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]">
          <template #header>
            <section class="flex justify-between items-center">
              <h1 class="text-lg md:text-2xl font-medium md:font-bold">Ledgers</h1>
              <Button as="Link" label="New" :href="route('ledgers.create')" icon="pi pi-plus" class="mr-2"/>
            </section>
          </template>
          <Column field="id" header="ID"/>
          <Column field="supplier" header="Supplier">
            <template #body="slotProps">
              {{ slotProps.data.supplier.name }}
            </template>
          </Column>
          <Column field="credit" header="Credit"/>
          <Column field="debit" header="Debit"/>
          <Column field="balance" header="Balance"/>
          <Column field="transaction_date" header="Transaction Date">
            <template #body="slotProps">
              {{ useDateFormat(slotProps.data.transaction_date, 'YYYY-MM-DD') }}
            </template>
          </Column>
          <Column field="created_at" header="Created At">
            <template #body="slotProps">
              {{ useDateFormat(slotProps.data.created_at, 'YYYY-MM-DD HH:mm:ss') }}
            </template>
          </Column>
          <Column header="Actions">
            <template #body="slotProps">
              <section class="inline-flex space-x-1">
                <Button as="Link" :href="route('ledgers.show',slotProps.data.id)" severity="success"
                        variant="outlined" icon="pi pi-eye" rounded aria-label="View"/>
                <Button as="Link" :href="route('ledgers.edit',slotProps.data.id)" severity="info"
                        variant="outlined" icon="pi pi-pencil" rounded aria-label="Edit"/>
                <Button @click="destroy(slotProps.data.id)" severity="danger" variant="outlined" icon="pi pi-trash"
                        rounded aria-label="Delete"/>
              </section>
            </template>
          </Column>
        </DataTable>
      </template>
      <template #footer> In total there are {{ ledgers.data.length }} ledgers.</template>
    </Card>
  </DefaultLayout>
</template>

<style scoped>

</style>