<script setup>
import {ref} from 'vue'
import Breadcrumb from "primevue/breadcrumb";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Select from "primevue/select";
import Card from 'primevue/card'
import {Form} from "@primevue/forms";
import {useForm} from "@inertiajs/vue3"
import {useToast} from "primevue/usetoast";

const {product, categories} = defineProps({
  product: {
    type: Object,
    required: true
  },
  categories: {
    type: Array,
    required: true
  },
})

const toast = useToast();

const items = ref([
  {label: 'Products', url: '/products'},
  {label: product.data.id, url: '/products/' + product.data.id},
  {label: 'Edit'}
])

const form = useForm({
  name: product.data.name,
  category_id: product.data.category_id,
  price: product.data.price,
  current_stock_quantity: product.data.current_stock_quantity
})


const save = () => {
  form.put(route('products.update', product.data.id), {
    onSuccess: () => toast.add({severity: 'info', summary: 'Success', detail: 'Product Updated', life: 3000})
  });

}
</script>

<template>
  <DefaultLayout title="Create A New Product">
    <Breadcrumb :home="{icon: 'pi pi-home',url: '/'}" :model="items"/>
    <Card>
      <template #title>
        <h1>Create A New Product</h1>
      </template>
      <template #content>
        <Form class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4" @submit="save">
          <div class="flex flex-col">
            <label for="name">Name</label>
            <input-text v-model="form.name" type="text" id="name" name="name"/>
            <span class="text-red-500" v-if="form.errors.name">{{ form.errors.name }}</span>
          </div>
          <div class="flex flex-col">
            <label for="category">Category</label>
            <Select id="category" v-model="form.category_id" option-value="id" :options="categories" optionLabel="name"
                    placeholder="Select a Category"/>
            <span class="text-red-500" v-if="form.errors.category_id">{{ form.errors.category_id }}</span>
          </div>
          <div class="flex flex-col">
            <label for="name">Price</label>
            <input-text v-model="form.price" type="text" id="name" name="name"/>
            <span class="text-red-500" v-if="form.errors.price">{{ form.errors.price }}</span>
          </div>
          <div class="flex flex-col">
            <label for="name">Current Stock</label>
            <input-text v-model="form.current_stock_quantity" type="text" id="name" name="name"/>
            <span class="text-red-500" v-if="form.errors.current_stock_quantity">{{
                form.errors.current_stock_quantity
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