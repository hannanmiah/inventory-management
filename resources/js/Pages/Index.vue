<script setup>
import Card from 'primevue/card';

const {totalProducts, totalPurchases, totalSuppliers, totalLedgers} = defineProps({
  totalPurchases: {
    type: Number,
    required: true
  },
  totalProducts: {
    type: Number,
    required: true
  },
  totalSuppliers: {
    type: Number,
    required: true
  },
  totalLedgers: {
    type: Number,
    required: true
  }
})
</script>

<template>
  <DefaultLayout title="Home">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
      <Card>
        <template #title>
          <h1>Total Products</h1>
        </template>
        <template #content>
          <p>{{ totalProducts }}</p>
        </template>
        <template #footer>
          <Link href="/products" class="text-blue-500 hover:text-blue-600 hover:underline">View All</Link>
        </template>
      </Card>
      <Card>
        <template #title>
          <h1>Total Purchases</h1>
        </template>
        <template #content>
          <p>{{ totalPurchases }}</p>
        </template>
        <template #footer>
          <Link href="/purchases" class="text-blue-500 hover:text-blue-600 hover:underline">View All</Link>
        </template>
      </Card>
      <Card>
        <template #title>
          <h1>Total Suppliers</h1>
        </template>
        <template #content>
          <p>{{ totalSuppliers }}</p>
        </template>
        <template #footer>
          <Link href="/suppliers" class="text-blue-500 hover:text-blue-600 hover:underline">View All</Link>
        </template>
      </Card>
      <Card>
        <template #title>
          <h1>Total Ledgers</h1>
        </template>
        <template #content>
          <p>{{ totalLedgers }}</p>
        </template>
        <template #footer>
          <Link href="/ledgers" class="text-blue-500 hover:text-blue-600 hover:underline">View All</Link>
        </template>
      </Card>
    </div>
  </DefaultLayout>
</template>
