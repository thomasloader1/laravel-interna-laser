<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
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
                    Productos!
                    <section class="grid grid-cols-3 gap-4">
                     <div v-for="(item, index) in $page.props.products" :key="index" class="border rounded-lg overflow-hidden flex flex-col justify-between" >
                         <img :src="item.image_url" :alt="item.name" class="w-full h-48 object-cover">
                         <div class="p-4 flex flex-col justify-between">
                             <div>
                                 <h2 class="font-bold text-lg">{{ item.name }}</h2>
                                 <p class="text-gray-700 mt-2">{{ item.description }}</p>
                             </div>
                             <div class="mt-4 flex justify-between items-end">
                                 <p class="text-gray-900 font-bold">${{ item.price }}</p>
                                 <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add to cart</a>
                             </div>
                         </div>
                     </div>
                    </section>
                </div>


            </div>
        </div>
    </AppLayout>
</template>
