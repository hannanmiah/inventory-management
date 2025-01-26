<script setup>
import {ref,computed,watch} from 'vue'
import Breadcrumb from "primevue/breadcrumb";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Select from "primevue/select";
import Card from 'primevue/card'
import {Form} from "@primevue/forms";
import {useForm} from "@inertiajs/vue3"
import {useToast} from "primevue/usetoast";

const {products, suppliers} = defineProps({
  products: {
    type: Array,
    required: true
  },
  suppliers: {
    type: Array,
    required: true
  }
})

const toast = useToast();

const items = ref([
  {label: 'Purchases', url: '/purchases'},
  {label: 'Create'}
])

const form = useForm({
  supplier_id: '',
  total_amount: 0,
  items: [
    {product_id: '', quantity: 0, unit_price: 0, total_price: 0}
  ]
})

const totalPrice = computed(() => {
  return form.items.reduce((total, item) => total + (item.quantity * item.unit_price), 0)
})

watch(totalPrice,() => form.total_amount = totalPrice.value)
const addItem = () => {
  form.items.push({product_id: '', quantity: 0, unit_price: 0, total_price: 0})
}


const save = () => {
  form.post('/purchases', {
    onSuccess: () => toast.add({severity: 'info', summary: 'Success', detail: 'Purchase Created', life: 3000})
  });

}
</script>

<template>
  <DefaultLayout title="Create Purchase">
    <Breadcrumb :home="{icon: 'pi pi-home',url: '/'}" :model="items"/>
    <Card>
      <template #title>
        <h1>Create A New Purchase</h1>
      </template>
      <template #content>
        <Form class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4" @submit="save">
          <div class="flex flex-col">
            <label for="name">Total Amount</label>
            <input-text v-model="form.total_amount" type="text" id="name" name="name" disabled/>
            <span class="text-red-500" v-if="form.errors.total_amount">{{ form.errors.total_amount }}</span>
          </div>
          <div class="flex flex-col">
            <label for="category">Supplier</label>
            <Select id="category" v-model="form.supplier_id" option-value="id" :options="suppliers" optionLabel="name"
                    placeholder="Select a Category"/>
            <span class="text-red-500" v-if="form.errors.supplier_id">{{ form.errors.supplier_id }}</span>
          </div>
          <section class="col-span-2 flex flex-col">
            <div class="flex justify-between">
              <h3>Items</h3>
              <Button @click="addItem" severity="secondary" type="button" icon="pi pi-plus" rounded/>
            </div>
            <span class="text-red-500" v-if="form.errors.item">{{ form.errors.items }}</span>
            <div class="">
              <div v-for="(item, index) in form.items" :key="index"
                   class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
                <div class="flex flex-col">
                  <label for="product_id">Product</label>
                  <Select id="product_id" v-model="item.product_id" option-value="id" :options="products"
                          optionLabel="name"
                          placeholder="Select a Product"/>
                </div>
                <div class="flex flex-col">
                  <label for="quantity">Quantity</label>
                  <input-text v-model="item.quantity" type="number" id="quantity" name="quantity"
                              @input="item.total_price = (item.unit_price * item.quantity)"/>
                </div>
                <div class="flex flex-col">
                  <label for="unit_price">Unit Price</label>
                  <input-text v-model="item.unit_price" type="number" id="unit_price" name="unit_price"
                              @input="item.total_price = (item.unit_price * item.quantity)"/>
                </div>
                <div class="flex flex-col">
                  <label for="total_price">Total Price</label>
                  <input-text v-model="item.total_price" type="text" id="total_price" name="total_price" disabled/>
                </div>
              </div>
            </div>
          </section>
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