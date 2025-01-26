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

const {suppliers} = defineProps({
  suppliers: {
    type: Array,
    required: true
  },
})

const toast = useToast();

const items = ref([
  {label: 'Ledgers', url: '/ledgers'},
  {label: 'Create'}
])

const form = useForm({
  supplier_id: '',
  credit: 0,
  debit: 0,
  transaction_date: new Date(),
  remarks: ''
})


const save = () => {
  form.post('/ledgers', {
    onSuccess: () => toast.add({severity: 'info', summary: 'Success', detail: 'Ledger Created', life: 3000})
  });

}
</script>

<template>
  <DefaultLayout title="Create A New Ledger">
    <Breadcrumb :home="{icon: 'pi pi-home',url: '/'}" :model="items"/>
    <Card>
      <template #title>
        <h1>Create A New Ledger</h1>
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