<script setup>
import {ref} from 'vue'
import Breadcrumb from "primevue/breadcrumb";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Card from 'primevue/card'
import {Form} from "@primevue/forms";
import {useForm} from "@inertiajs/vue3"
import {useToast} from "primevue/usetoast";

const {supplier} = defineProps({
  supplier: {
    type: Object,
    required: true
  }
})
const toast = useToast();

const items = ref([
  {label: 'Suppliers', url: '/suppliers'},
  {label: supplier.data.id, url: '/suppliers/' + supplier.data.id},
  {label: 'Edit'}
])

const form = useForm({
  name: supplier.data.name,
  address: supplier.data.address,
  contact_info: {
    phone: supplier.data.contact_info?.phone,
    email: supplier.data.contact_info?.email
  }
})


const save = () => {
  form.put('/suppliers/'+supplier.data.id, {
    onSuccess: () => toast.add({severity: 'info', summary: 'Success', detail: 'Supplier Created', life: 3000})
  });
}
</script>

<template>
  <DefaultLayout title="Create A New Suppler">
    <Breadcrumb :home="{icon: 'pi pi-home',url: '/'}" :model="items"/>
    <Card>
      <template #title>
        <h1>Edit Supplier</h1>
      </template>
      <template #content>
        <Form class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4" @submit="save">
          <div class="flex flex-col">
            <label for="name">Name</label>
            <input-text v-model="form.name" type="text" id="name" name="name"/>
            <span class="text-red-500" v-if="form.errors.name">{{ form.errors.name }}</span>
          </div>
          <div class="flex flex-col">
            <label for="address">Address</label>
            <input-text v-model="form.address" type="text" id="address" name="address"/>
            <span class="text-red-500" v-if="form.errors.address">{{ form.errors.address }}</span>
          </div>
          <div class="flex flex-col">
            <label for="phone">Phone</label>
            <input-text v-model="form.contact_info.phone" type="text" id="phone" name="phone"/>
            <span class="text-red-500" v-if="form.errors.contact_info?.phone">{{
                form.errors.contact_info?.phone
              }}</span>
          </div>
          <div class="flex flex-col">
            <label for="email">Email</label>
            <input-text v-model="form.contact_info.email" type="email" id="email" name="email"/>
            <span class="text-red-500" v-if="form.errors.contact_info?.email">{{
                form.errors.contact_info?.email
              }}</span>
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