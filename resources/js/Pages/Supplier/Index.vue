<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Card from "primevue/card";
import Breadcrumb from 'primevue/breadcrumb';
import Button from "primevue/button";
import {ref} from 'vue'
import {useDateFormat} from "@vueuse/core";
import {router} from "@inertiajs/vue3";
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "primevue/usetoast";

const {suppliers} = defineProps({
  suppliers: {
    type: Object,
    required: true,
  }
})

const items = ref([
  {label: 'Suppliers'},
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
      router.delete(route('suppliers.destroy', id))
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
          <h1 class="text-lg md:text-2xl font-medium md:font-bold">Suppliers</h1>
          <Button as="Link" label="New" :href="route('suppliers.create')" icon="pi pi-plus" class="mr-2"/>
        </section>
      </template>
      <template #content>
        <DataTable :value="suppliers.data" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]">
          <Column field="id" header="ID"/>
          <Column field="name" header="Name"/>
          <Column field="address" header="Address"/>
          <Column field="contact_info.phone" header="Phone"/>
          <Column field="contact_info.email" header="Email"/>
          <Column field="created_at" header="Created At">
            <template #body="slotProps">
              {{ useDateFormat(slotProps.data.created_at, 'YYYY-MM-DD HH:mm:ss') }}
            </template>
          </Column>
          <Column header="Actions">
            <template #body="slotProps">
              <section class="inline-flex space-x-1">
                <Button as="Link" :href="route('suppliers.show',slotProps.data.id)" severity="success"
                        variant="outlined" icon="pi pi-eye" rounded aria-label="View"/>
                <Button as="Link" :href="route('suppliers.edit',slotProps.data.id)" severity="info"
                        variant="outlined" icon="pi pi-pencil" rounded aria-label="Edit"/>
                <Button @click="destroy(slotProps.data.id)" severity="danger" variant="outlined" icon="pi pi-trash"
                        rounded aria-label="Delete"/>
              </section>
            </template>
          </Column>
        </DataTable>
      </template>
      <template #footer> In total there are {{ suppliers.data.length }} suppliers.</template>
    </Card>
  </DefaultLayout>
</template>

<style scoped>

</style>