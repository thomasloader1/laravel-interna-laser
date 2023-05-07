import { createStore } from 'vuex'

const store = createStore({
  state: {
    products: [],
    selectedProduct: null // nuevo estado para almacenar el producto seleccionado
  },
  mutations: {
    setProducts(state, products) {
      const mappingProducts = products.map(p => ({...p, showModal: false}));
      state.products = mappingProducts
    },
    setSelectedProduct(state, product) { // nueva mutación para actualizar el producto seleccionado
      state.selectedProduct = product
    }
  },
  actions: {
    async fetchProducts({ commit }) {
      const response = await fetch('/admin/products')
      if (response.ok) {
        const products = await response.json()
        commit('setProducts', products)
      } else {
        console.error('Failed to fetch products.')
      }
    },
    async updateProduct({ commit }, product) {
      const formData = new FormData();
      formData.append('name', product.name);
      formData.append('description', product.description);
      formData.append('image_url', product.image_url);

      const response = await fetch(`/products/${product.id}`, {
        method: 'POST',
        body: formData
      });

      if (response.ok) {
        const updatedProduct = await response.json();
        commit('updateProduct', updatedProduct);
      } else {
        console.error('Failed to update product.');
      }
    },
    selectProduct({ commit }, product) { // nueva acción para seleccionar un producto
      commit('setSelectedProduct', product)
    }
  }
})

export default store
