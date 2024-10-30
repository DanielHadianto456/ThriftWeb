<template>
  <Sidebar />
  <div class="wrapper">
    <div class="header-container">
      <div class="title-container">
        <h1>All Categories</h1>
        <router-link to="/admin/add-category" class="add-button">Add Category</router-link>
      </div>
    </div>
    <div class="table-container">
      <table class="table-list">
        <thead>
          <tr>
            <td>Name</td>
            <td>Actions</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in categories" :key="category.kategori_pakaian_id">
            <td>{{ category.kategori_pakaian_nama }}</td>
            <td>
              <button @click="openEditModal(category.kategori_pakaian_id)">Edit</button>
              <button @click="deleteCategory(category.kategori_pakaian_id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <EditCategoryModal :isOpen="isEditModalOpen" :categoryId="selectedCategoryId" @close="closeEditModal" @categoryEdited="fetchCategories" />
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useCategoryStore } from "@/stores/categoryStore";
import Sidebar from "../../Sidebar.vue";
import EditCategoryModal from "../../EditCategoryModal.vue";

export default {
  name: "AllCategories",
  components: {
    Sidebar,
    EditCategoryModal,
  },
  setup() {
    const categories = ref([]);
    const isEditModalOpen = ref(false);
    const selectedCategoryId = ref(null);

    const fetchCategories = async () => {
      try {
        const store = useCategoryStore();
        await store.fetchCategories();
        categories.value = store.categories;
      } catch (error) {
        console.error("Failed to fetch categories:", error);
      }
    };

    const openEditModal = (categoryId) => {
      selectedCategoryId.value = categoryId;
      isEditModalOpen.value = true;
    };

    const closeEditModal = () => {
      isEditModalOpen.value = false;
      selectedCategoryId.value = null;
    };

    const deleteCategory = async (categoryId) => {
      try {
        const store = useCategoryStore();
        await store.deleteCategory(categoryId);
        fetchCategories();
      } catch (error) {
        console.error("Failed to delete category:", error);
      }
    };

    onMounted(() => {
      fetchCategories();
    });

    return {
      categories,
      isEditModalOpen,
      selectedCategoryId,
      openEditModal,
      closeEditModal,
      fetchCategories,
      deleteCategory,
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

.add-button {
  padding: 0.5rem 1rem;
  background-color: #007bff;
  color: white;
  border: none;
  cursor: pointer;
  border-radius: 4px;
  text-decoration: none;
}

.add-button:hover {
  background-color: #0056b3;
}

.table-container {
  overflow-x: auto;
}

.table-list {
  width: 100%;
  border-collapse: collapse;
}

.table-list th,
.table-list td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.table-list th {
  background-color: #f9f9f9;
  font-weight: bold;
}

.table-list tr:hover {
  background-color: #f1f1f1;
}

.table-list td {
  color: black;
}
</style>