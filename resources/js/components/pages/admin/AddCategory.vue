<template>
  <Sidebar />
  <div :class="['wrapper', { 'wrapper-mobile': isMobile }]">
    <div class="header-container">
      <div class="title-container">
        <h1>Add Category</h1>
      </div>
    </div>
    <form @submit.prevent="addCategory">
      <div class="form-group">
        <label for="kategori_pakaian_nama">Category Name:</label>
        <input type="text" v-model="kategori_pakaian_nama" id="kategori_pakaian_nama" required />
      </div>
      <button type="submit">Add Category</button>
    </form>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useCategoryStore } from "@/stores/categoryStore";
import Sidebar from "../../Sidebar.vue";

export default {
  name: "AddCategory",
  components: {
    Sidebar,
  },
  setup() {
    const kategori_pakaian_nama = ref("");
    const isMobile = ref(window.innerWidth <= 768);

    const addCategory = async () => {
      try {
        const store = useCategoryStore();
        await store.addCategory({ kategori_pakaian_nama: kategori_pakaian_nama.value });
        alert("Category added successfully!");
        kategori_pakaian_nama.value = ""; // Clear the input field
      } catch (error) {
        console.error("Failed to add category:", error);
        alert("Failed to add category.");
      }
    };

    onMounted(() => {
      window.addEventListener('resize', () => {
        isMobile.value = window.innerWidth <= 768;
      });
    });

    return {
      kategori_pakaian_nama,
      addCategory,
      isMobile,
    };
  },
};
</script>

<style scoped>
.wrapper {
  padding: 1rem;
  margin-left: 250px; /* Adjust for sidebar width */
}

.wrapper-mobile {
  margin-left: 0;
  padding-top: 4rem; /* Add padding for mobile view to avoid overlap */
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

input[type="text"] {
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