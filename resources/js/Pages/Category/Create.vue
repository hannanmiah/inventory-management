<script setup>
import {ref} from 'vue'
import Breadcrumb from "primevue/breadcrumb";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Card from 'primevue/card'
import {Form} from "@primevue/forms";
import {useForm} from "@inertiajs/vue3"
import {useToast} from "primevue/usetoast";


const toast = useToast();

const items = ref([
  {label: 'Categories', url: '/categories'},
  {label: 'Create'}
])

const form = useForm({
  name: ''
})


const save = () => {
  form.post('/categories', {
    onSuccess: () => toast.add({severity: 'info', summary: 'Success', detail: 'Categories Created', life: 3000})
  });

}
</script>

<template>
  <DefaultLayout title="Create A New Category">
    <Breadcrumb :home="{icon: 'pi pi-home',url: '/'}" :model="items"/>
    <Card>
      <template #title>
        <h1>Create A New Category</h1>
      </template>
      <template #content>
        <Form class="flex flex-col gap-2 md:gap-4" @submit="save">
          <div class="flex flex-col">
            <label for="name">Name</label>
            <InputText id="name" v-model="form.name" placeholder="Enter Category Name"/>
            <span class="text-red-500" v-if="form.errors.name">{{ form.errors.name }}</span>
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