<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Card from "primevue/card";
import Breadcrumb from 'primevue/breadcrumb';
import {ref} from 'vue'
import {useDateFormat} from "@vueuse/core";
import Button from "primevue/button";
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "primevue/usetoast";
import {router} from "@inertiajs/vue3";

const {ledgers} = defineProps({
  ledgers: {
    type: Object,
    required: true,
  }
})

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
  <DefaultLayout title="Products">
    <Breadcrumb :home="{icon: 'pi pi-home', url: '/'}" :model="items"/>
    <Card>
      <template #title>
        <section class="flex justify-between items-center">
          <h1 class="text-lg md:text-2xl font-medium md:font-bold">Ledgers</h1>
          <Button as="Link" label="New" :href="route('ledgers.create')" icon="pi pi-plus" class="mr-2"/>
        </section>
      </template>
      <template #content>
        <DataTable :value="ledgers.data" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]">
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