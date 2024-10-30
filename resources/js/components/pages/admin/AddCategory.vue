<template>
  <Header />
  <div class="wrapper">
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
import { ref } from "vue";
import { useCategoryStore } from "@/stores/categoryStore";
import Header from "../../Header.vue";

export default {
  name: "AddCategory",
  components: {
    Header,
  },
  setup() {
    const kategori_pakaian_nama = ref("");

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

    return {
      kategori_pakaian_nama,
      addCategory,
    };
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