<script setup>
import { computed, ref } from 'vue'
import { useStore } from 'vuex'
//import EditProductModal from './EditProductModal.vue'

const store = useStore()

store.dispatch('fetchProducts')

const products = computed(() => store.state.products)

const activeAccordion = ref(null)

function toggleAccordion(product) {
    activeAccordion.value = activeAccordion.value === product ? null : product
}

function editProduct(product) {
  store.commit('setSelectedProduct', product)
  const modal = new bootstrap.Modal(document.getElementById('editProductModal'))
  modal.show()
}
</script>

<template>
    <div class="w-full" v-for="product in products" :key="product.id">
      <div class="border border-gray-200 rounded-md">
        <div
          class="flex justify-between items-center px-6 py-4 border-b border-gray-200 cursor-pointer"
          @click="toggleAccordion(product)"
        >
          <h3 class="text-lg leading-6 font-medium text-gray-900">{{ product.name }}</h3>
          <svg
            class="w-6 h-6 text-gray-400 transform transition-transform"
            :class="{'rotate-90': activeAccordion === product}"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5l7 7-7 7"
            ></path>
          </svg>
        </div>
        <div class="p-4" :class="{ 'hidden': activeAccordion !== product }">
          <div class="flex items-center mb-4">
            <img :src="product.image_url" :alt="product.name" class="w-1/4 mr-4">
            <div class="w-3/4">
              <div class="flex justify-start items-center mb-2">
                <p class="text-lg font-medium text-gray-900">{{ product.name }}</p>
              </div>
              <div class="flex flex-col justify-between items-start my-4">
                  <p class="text-sm text-gray-500 mb-2">{{ product.description }}</p>
                  <p class="text-gray-700 text-sm ">{{ product.stock }} en stock</p>
                  <p class="text-lg font-medium text-gray-900">${{ product.price }}</p>
              </div>
              <div class="flex justify-between items-center mb-2">
                <div class="flex items-center space-x-2">
                  <button
                    class="inline-flex items-center px-2 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                    @click="editProduct(product)"
                  >
                    Editar
                  </button>
                  <button
                    class="inline-flex items-center px-2 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-800 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    @click="deleteProduct(product)"
                  >
                    Borrar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
