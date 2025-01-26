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

const {purchase, products, suppliers} = defineProps({
  purchase: {
    type: Object,
    required: true
  },
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
  {label: purchase.data.id, url: '/purchases/' + purchase.data.id},
  {label: 'Edit'}
])

const form = useForm({
  supplier_id: purchase.data.supplier_id,
  total_amount: purchase.data.total_amount,
  items: purchase.data.purchase_items
})

const addItem = () => {
  form.items.push({product_id: '', quantity: 0, unit_price: 0, total_price: 0})
}


const save = () => {
  form.put('/purchases/'+purchase.data.id, {
    onSuccess: () => toast.add({severity: 'info', summary: 'Success', detail: 'Purchase Updated', life: 3000})
  });

}
</script>

<template>
  <DefaultLayout title="Edit Purchase">
    <Breadcrumb :home="{icon: 'pi pi-home',url: '/'}" :model="items"/>
    <Card>
      <template #title>
        <h1>Update Purchase</h1>
      </template>
      <template #content>
        <Form class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4" @submit="save">
          <div class="flex flex-col">
            <label for="name">Total Amount</label>
            <input-text v-model="form.total_amount" type="text" id="name" name="name"/>
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