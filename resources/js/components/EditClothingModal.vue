<template>
  <div v-if="isOpen" class="modal">
    <div class="modal-content">
      <button class="close-modal-button" @click="closeModal">&times;</button>
      <h2>Edit Clothing Item</h2>
      <form @submit.prevent="editClothing">
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
          <input type="file" @change="handleFileUpload" id="pakaian_gambar_url" />
        </div>
        <button type="submit">Edit Clothing</button>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useClothingStore } from "@/stores/clothingStore";
import { useCategoryStore } from "@/stores/categoryStore";

export default {
  name: "EditClothingModal",
  props: {
    isOpen: {
      type: Boolean,
      required: true,
    },
    pakaianId: {
      type: Number,
      required: true,
    },
  },
  setup(props, { emit }) {
    const kategori_pakaian_id = ref("");
    const pakaian_nama = ref("");
    const pakaian_harga = ref("");
    const pakaian_stok = ref("");
    const pakaian_gambar_url = ref(null);
    const categories = ref([]);

    const handleFileUpload = (event) => {
      pakaian_gambar_url.value = event.target.files[0];
    };

    const fetchClothingDetails = async () => {
      try {
        const store = useClothingStore();
        const data = await store.getClothingById(props.pakaianId);
        kategori_pakaian_id.value = data.kategori_pakaian_id;
        pakaian_nama.value = data.pakaian_nama;
        pakaian_harga.value = data.pakaian_harga;
        pakaian_stok.value = data.pakaian_stok;
        pakaian_gambar_url.value = data.pakaian_gambar_url;
      } catch (error) {
        console.error("Failed to fetch clothing details:", error);
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

    const editClothing = async () => {
      try {
        const store = useClothingStore();
        const formData = new FormData();
        formData.append("kategori_pakaian_id", kategori_pakaian_id.value);
        formData.append("pakaian_nama", pakaian_nama.value);
        formData.append("pakaian_harga", pakaian_harga.value);
        formData.append("pakaian_stok", pakaian_stok.value);
        if (pakaian_gambar_url.value) {
          formData.append("pakaian_gambar_url", pakaian_gambar_url.value);
        }
        await store.editClothing(props.pakaianId, formData);
        alert("Clothing item edited successfully!");
        emit("clothingEdited"); // Emit event after editing clothing
        closeModal();
      } catch (error) {
        console.error("Failed to edit clothing item:", error);
        alert("Failed to edit clothing item.");
      }
    };

    const closeModal = () => {
      emit("close");
    };

    onMounted(() => {
      fetchClothingDetails();
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
      editClothing,
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

input[type="text"],
input[type="number"],
input[type="file"] {
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