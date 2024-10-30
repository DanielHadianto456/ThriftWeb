<template>
  <Sidebar />
  <div class="wrapper">
    <div class="header-container">
      <div class="title-container">
        <h1>All Clothing Items</h1>
        <router-link to="/admin/add-clothing" class="add-button">Add Clothing</router-link>
      </div>
    </div>
    <div class="table-container">
      <table class="table-list">
        <thead>
          <tr>
            <td>Image</td>
            <td>Name</td>
            <td>Category</td>
            <td>Price</td>
            <td>Stock</td>
            <td>Actions</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="clothing in clothings" :key="clothing.pakaian_id">
            <td><img :src="`/storage/${clothing.pakaian_gambar_url}`" alt="Clothing Image" width="50" /></td>
            <td>{{ clothing.pakaian_nama }}</td>
            <td>{{ clothing.kategori.kategori_pakaian_nama }}</td>
            <td>Rp. {{ clothing.pakaian_harga.toLocaleString("id-ID") }}</td>
            <td>{{ clothing.pakaian_stok }}</td>
            <td>
              <button @click="openAddStockModal(clothing.pakaian_id)">Add Stock</button>
              <button @click="openEditModal(clothing.pakaian_id)">Edit</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <AddStockModal :isOpen="isAddStockModalOpen" :pakaianId="selectedPakaianId" @close="closeAddStockModal" @stockAdded="fetchClothings" />
    <EditClothingModal :isOpen="isEditModalOpen" :pakaianId="selectedPakaianId" @close="closeEditModal" @clothingEdited="fetchClothings" />
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useClothingStore } from "@/stores/clothingStore";
import Sidebar from "../../Sidebar.vue";
import AddStockModal from "../../AddStockModal.vue";
import EditClothingModal from "../../EditClothingModal.vue";

export default {
  name: "AllClothing",
  components: {
    Sidebar,
    AddStockModal,
    EditClothingModal,
  },
  setup() {
    const clothings = ref([]);
    const isAddStockModalOpen = ref(false);
    const isEditModalOpen = ref(false);
    const selectedPakaianId = ref(null);

    const fetchClothings = async () => {
      try {
        const store = useClothingStore();
        const data = await store.getAllClothing();
        clothings.value = data;
      } catch (error) {
        console.error("Failed to fetch clothing items:", error);
      }
    };

    const openAddStockModal = (pakaianId) => {
      selectedPakaianId.value = pakaianId;
      isAddStockModalOpen.value = true;
    };

    const closeAddStockModal = () => {
      isAddStockModalOpen.value = false;
      selectedPakaianId.value = null;
    };

    const openEditModal = (pakaianId) => {
      selectedPakaianId.value = pakaianId;
      isEditModalOpen.value = true;
    };

    const closeEditModal = () => {
      isEditModalOpen.value = false;
      selectedPakaianId.value = null;
    };

    onMounted(() => {
      fetchClothings();
    });

    return {
      clothings,
      isAddStockModalOpen,
      isEditModalOpen,
      selectedPakaianId,
      openAddStockModal,
      closeAddStockModal,
      openEditModal,
      closeEditModal,
      fetchClothings,
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