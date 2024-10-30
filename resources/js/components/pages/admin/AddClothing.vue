<template>
  <Sidebar />
  <div class="wrapper">
    <div class="header-container">
      <div class="title-container">
        <h1>Add Clothing Item</h1>
      </div>
    </div>
    <form @submit.prevent="addClothing">
      <div class="form-group">
        <label for="kategori_pakaian_id">Category:</label>
        <select v-model="kategori_pakaian_id" id="kategori_pakaian_id" required>
          <option v-for="category in categories" :key="category.kategori_pakaian_id" :value="category.kategori_pakaian_id">
            {{ category.kategori_pakaian_nama }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <label for="pakaian_nama">Name:</label>
        <input type="text" v-model="pakaian_nama" id="pakaian_nama" required />
      </div>
      <div class="form-group">
        <label for="pakaian_harga">Price:</label>
        <input type="text" v-model="pakaian_harga" id="pakaian_harga" required />
      </div>
      <div class="form-group">
        <label for="pakaian_stok">Stock:</label>
        <input type="text" v-model="pakaian_stok" id="pakaian_stok" required />
      </div>
      <div class="form-group">
        <label for="pakaian_gambar_url">Image:</label>
        <input type="file" @change="handleFileUpload" id="pakaian_gambar_url" required />
      </div>
      <button type="submit">Add Clothing</button>
    </form>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useClothingStore } from "@/stores/clothingStore";
import { useCategoryStore } from "@/stores/categoryStore";
import Sidebar from "../../Sidebar.vue";

export default {
  name: "AddClothing",
  components: {
    Sidebar,
  },
  setup() {
    const kategori_pakaian_id = ref("");
    const pakaian_nama = ref("");
    const pakaian_harga = ref("");
    const pakaian_stok = ref("");
    const pakaian_gambar_url = ref(null);
    const categories = ref([]);

    const handleFileUpload = (event) => {
      pakaian_gambar_url.value = event.target.files[0];
    };

    const addClothing = async () => {
      try {
        const store = useClothingStore();
        const formData = new FormData();
        formData.append("kategori_pakaian_id", kategori_pakaian_id.value);
        formData.append("pakaian_nama", pakaian_nama.value);
        formData.append("pakaian_harga", pakaian_harga.value);
        formData.append("pakaian_stok", pakaian_stok.value);
        formData.append("pakaian_gambar_url", pakaian_gambar_url.value);

        await store.addClothing(formData);
        alert("Clothing item added successfully!");
      } catch (error) {
        console.error("Failed to add clothing item:", error);
        alert("Failed to add clothing item.");
      }
    };

    const fetchCategories = async () => {
      try {
        const store = useCategoryStore();
        await store.fetchCategories();
        categories.value = store.categories;
      } catch (error) {
        console.error("Failed to fetch categories:", error);
      }
    };

    onMounted(() => {
      fetchCategories();
    });

    return {
      kategori_pakaian_id,
      pakaian_nama,
      pakaian_harga,
      pakaian_stok,
      pakaian_gambar_url,
      categories,
      handleFileUpload,
      addClothing,
    };
  },
};
</script>

<style scoped>
.wrapper {
  padding: 1rem;
  margin-left: 250px; /* Adjust for sidebar width */
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

.form-group {
  margin-bottom: 1rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
}

input[type="text"],
input[type="number"],
input[type="file"],
select {
  width: 100%;
  padding: 0.5rem;
  margin-bottom: 0.5rem;
}

button {
  padding: 0.5rem 1rem;
  background-color: #007bff;
  color: white;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}
</style>