<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ListProducts from '../Components/ListProducts.vue';
import TableProducts from '../Components/TableProducts.vue';
</script>

<template>
    <AppLayout title="Productos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Productos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                   <h3 class="mb-4 font-semibold">Productos disponibles</h3>
                    <TableProducts />
                </div>


            </div>
        </div>
    </AppLayout>
</template>
