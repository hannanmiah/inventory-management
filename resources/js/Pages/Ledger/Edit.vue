<script setup>
import {ref} from 'vue'
import Breadcrumb from "primevue/breadcrumb";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Select from "primevue/select";
import DatePicker from 'primevue/datepicker';
import Textarea from "primevue/textarea";
import Card from 'primevue/card'
import {Form} from "@primevue/forms";
import {useForm} from "@inertiajs/vue3"
import {useToast} from "primevue/usetoast";

const {ledger, suppliers} = defineProps({
  ledger: {
    type: Object,
    required: true
  },
  suppliers: {
    type: Array,
    required: true
  },
})

const toast = useToast();

const items = ref([
  {label: 'Ledgers', url: '/ledgers'},
  {label: ledger.data.id, url: '/ledgers/' + ledger.data.id},
  {label: 'Edit'}
])

const form = useForm({
  supplier_id: ledger.data.supplier_id,
  credit: ledger.data.credit,
  debit: ledger.data.debit,
  transaction_date: ledger.data.transaction_date,
  remarks: ledger.data.remarks
})


const save = () => {
  form.put('/ledgers/'+ledger.data.id, {
    onSuccess: () => toast.add({severity: 'info', summary: 'Success', detail: 'Ledger Updated', life: 3000})
  });

}
</script>

<template>
  <DefaultLayout title="Update Ledger">
    <Breadcrumb :home="{icon: 'pi pi-home',url: '/'}" :model="items"/>
    <Card>
      <template #title>
        <h1>Edit Ledger</h1>
      </template>
      <template #content>
        <Form class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4" @submit="save">
          <div class="flex flex-col">
            <label for="category">Supplier</label>
            <Select id="category" v-model="form.supplier_id" option-value="id" :options="suppliers" optionLabel="name"
                    placeholder="Select a Supplier"/>
            <span class="text-red-500" v-if="form.errors.supplier_id">{{ form.errors.supplier_id }}</span>
          </div>
          <div class="flex flex-col">
            <label for="credit">Credit</label>
            <InputText id="credit" v-model="form.credit" type="number" placeholder="Enter Credit Amount"/>
            <span class="text-red-500" v-if="form.errors.credit">{{ form.errors.credit }}</span>
          </div>
          <div class="flex flex-col">
            <label for="debit">Debit</label>
            <InputText id="debit" v-model="form.debit" type="number" placeholder="Enter Debit Amount"/>
            <span class="text-red-500" v-if="form.errors.debit">{{ form.errors.debit }}</span>
          </div>
          <div class="flex flex-col">
            <label for="transaction_date">Transaction Date</label>
            <DatePicker v-model="form.transaction_date"/>
            <span class="text-red-500" v-if="form.errors.transaction_date">{{ form.errors.transaction_date }}</span>
          </div>
          <div class="flex flex-col md:col-span-2">
            <label for="remarks">Remarks</label>
            <Textarea id="remarks" v-model="form.remarks" placeholder="Enter Remarks"/>
            <span class="text-red-500" v-if="form.errors.remarks">{{ form.errors.remarks }}</span>
          </div>
          <div class="flex flex-col md:col-span-2">
            <Button type="submit" label="Save" class="w-full mt-4"/>
          </div>
        </Form>
      </template>
    </Card>
  </DefaultLayout>
</template>

<style scoped>

</style>