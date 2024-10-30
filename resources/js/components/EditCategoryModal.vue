<template>
  <div v-if="isOpen" class="modal">
    <div class="modal-content">
      <button class="close-modal-button" @click="closeModal">&times;</button>
      <h2>Edit Category</h2>
      <form @submit.prevent="editCategory">
        <div class="form-group">
          <label for="kategori_pakaian_nama">Category Name:</label>
          <input type="text" v-model="kategori_pakaian_nama" id="kategori_pakaian_nama" required />
        </div>
        <button type="submit">Edit Category</button>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useCategoryStore } from "@/stores/categoryStore";

export default {
  name: "EditCategoryModal",
  props: {
    isOpen: {
      type: Boolean,
      required: true,
    },
    categoryId: {
      type: Number,
      required: true,
    },
  },
  setup(props, { emit }) {
    const kategori_pakaian_nama = ref("");

    const fetchCategoryDetails = async () => {
      try {
        const store = useCategoryStore();
        const data = await store.getCategoryById(props.categoryId);
        kategori_pakaian_nama.value = data.kategori_pakaian_nama;
      } catch (error) {
        console.error("Failed to fetch category details:", error);
      }
    };

    const editCategory = async () => {
      try {
        const store = useCategoryStore();
        await store.editCategory(props.categoryId, { kategori_pakaian_nama: kategori_pakaian_nama.value });
        alert("Category edited successfully!");
        emit("categoryEdited"); // Emit event after editing category
        closeModal();
      } catch (error) {
        console.error("Failed to edit category:", error);
        alert("Failed to edit category.");
      }
    };

    const closeModal = () => {
      emit("close");
    };

    onMounted(() => {
      fetchCategoryDetails();
    });

    return {
      kategori_pakaian_nama,
      editCategory,
      closeModal,
    };
  },
};
</script>

<style scoped>
.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  position: relative;
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  width: 80%;
  max-width: 400px;
}

.close-modal-button {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #333;
}

.close-modal-button:hover {
  color: #f44336;
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