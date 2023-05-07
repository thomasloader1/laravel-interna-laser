<script setup>
import { computed } from "vue";
import { useStore } from "vuex"
import InputLabel from "./InputLabel.vue"
import DialogModal from "./DialogModal.vue";
import TextInput from "./TextInput.vue";

const store = useStore();

function toggleModal() {
    store.commit('toggleModal');
}

const showModal = computed(() => {
  return store.state.showModal;
});

async function updateProduct() {
      const formData = new FormData();
      formData.append('name', this.product.name);
      formData.append('description', this.product.description);
      formData.append('image_url', this.product.image_url);

      const response = await fetch(`/products/${this.$route.params.id}`, {
        method: 'POST',
        body: formData
      });

      if (response.ok) {
        const product = await response.json();
        this.$router.push({ name: 'ProductDetails', params: { id: product.id } });
      } else {
        console.error('Failed to update product.');
      }
    }

function handleFileInput(event) {
      const file = event.target.files[0];
      console.log({file, event})
      if (!file.type.startsWith('image/')) {
        return;
      }
      this.product.image_url = file;
    }
</script>

<template>
  <section class="grid grid-cols-3 gap-4" >
    <div
      v-for="(item, index) in $page.props.products"
      :key="index"
      class="border rounded-lg overflow-hidden flex flex-col justify-between"
    >
      <img
        :src="item.image_url"
        :alt="item.name"
        class="w-full h-48 object-cover"
      />
      <div class="p-4 flex flex-col justify-between">
        <div>
          <h2 class="font-bold text-lg">{{ item.name }}</h2>
          <p class="text-gray-700 mt-2">{{ item.description }}</p>
        </div>
        <div class="mt-4 flex justify-between items-end">
          <p class="text-gray-900 font-bold">${{ item.price }}</p>
          <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            @click="toggleModal"
          >
            Editar producto
          </button>
        </div>
      </div>

      <DialogModal :show="showModal">
        <template #title>
          Editar Producto <span class="font-semibold">{{ item.name }}</span>
        </template>

        <template #content>
          <form @submit.prevent="updateProduct">
            <div class="mb-3">
                <InputLabel :for="'name'+item.id" value="Nombre" />
                <TextInput
                    :id="'name'+item.name"
                    v-model="item.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                />
            </div>
            <div class="mb-3">
                <InputLabel :for="'price'+item.id" value="Precio" />
                <TextInput
                    :id="'price'+item.id"
                    v-model="item.price"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="price"
                />
            </div>
            <div class="mb-3">
                <InputLabel :for="'stock'+item.id" value="Stock" />
                <TextInput
                    :id="'stock'+item.id"
                    v-model="item.stock"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="stock"
                />
            </div>
            <div class="mb-3">
                <InputLabel :for="'image_url'+item.id" value="Imagen" />
                <input type="file" @change="handleFileInput" class="mt-1 block w-full" />
                <img :src="item.image_url" v-if="item.image_url" class="mt-2 h-32" />
            </div>
          </form>
        </template>

        <template #footer>
          <button
            class="mr-3 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline bg-green-600 hover:bg-green-500 focus:border-green-700 active:bg-green-700"
            type="submit"
          >
            Guardar cambios
          </button>
          <button
            class="text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline bg-gray-400 hover:bg-gray-300 focus:border-gray-500 active:bg-gray-500"
            type="button"
            @click="toggleModal"
          >
            Cerrar
          </button>
        </template>
      </DialogModal>
    </div>
  </section>
</template>
