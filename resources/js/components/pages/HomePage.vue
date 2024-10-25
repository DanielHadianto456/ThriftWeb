<template>
  <Header />
  <div class="wrapper">
    <div class="header-container">
      <div class="title-container">
        <h1>Clothing</h1>
        <h2>Daftar Pakaian</h2>
      </div>
      <div class="button-container">
        <button @click="openCart">View Cart</button>
      </div>
    </div>
    <div class="grid-container">
      <div class="card" v-for="clothing in clothings" :key="clothing.pakaian_id">
        <img :src="`/storage/${clothing.pakaian_gambar_url}`" alt="Clothing Image" />
        <div class="card-content">
          <h3>{{ clothing.pakaian_nama }}</h3>
          <p>Kategori: {{ clothing.kategori.kategori_pakaian_nama }}</p>
          <p>Harga: Rp. {{ clothing.pakaian_harga.toLocaleString("id-ID") }}</p>
          <p>Stok: {{ clothing.pakaian_stok }}</p>
          <button :disabled="clothing.pakaian_stok === 0" @click="addToCart(clothing)">
            Add to Cart
          </button>
        </div>
      </div>
    </div>
    <CartModal />
  </div>
</template>

<script>
import { getAllClothing } from "@/stores/clothingStore";
import { useCartStore } from "@/stores/cartStore";
import Header from "../Header.vue";
import CartModal from "../CartModal.vue";

export default {
  name: "HomePage",
  components: {
    Header,
    CartModal,
  },
  data() {
    return {
      clothings: [],
    };
  },
  methods: {
    async fetchClothing() {
      try {
        const store = getAllClothing();
        const data = await store.authenticate("user/pakaian");
        console.log("Fetched data:", data);
        this.clothings = data.data;
      } catch (error) {
        console.log(error);
      }
    },
    addToCart(clothing) {
      const cartStore = useCartStore();
      cartStore.addToCart({ ...clothing, jumlah: 1 });
      clothing.pakaian_stok -= 1; // Update stock in the product list
    },
    openCart() {
      const cartStore = useCartStore();
      cartStore.openCart();
    },
  },
  mounted() {
    this.fetchClothing();
  },
};
</script>

<style scoped>
.wrapper {
  padding: 1rem;
}

.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.title-container h1 {
  margin: 0;
}

.button-container .button {
  background-color: #007bff;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  text-decoration: none;
}

.button-container .button:hover {
  background-color: #0056b3;
}

.grid-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1rem;
}

.card {
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 1rem;
  box-sizing: border-box;
}

.card img {
  width: 100%;
  height: auto;
  border-radius: 4px;
}

.card-content {
  margin-top: 0.5rem;
}

.card-content h3 {
  margin: 0;
}

.card-content p {
  margin: 0.25rem 0;
}

button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
</style>