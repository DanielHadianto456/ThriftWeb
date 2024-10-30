<template>
  <div v-if="isOpen" class="modal">
    <div class="modal-content">
      <button class="close-modal-button" @click="closeModal">&times;</button>
      <h2>Add Stock</h2>
      <form @submit.prevent="addStock">
        <div class="form-group">
          <label for="stock">Stock:</label>
          <input type="number" v-model="stock" id="stock" required />
        </div>
        <button type="submit">Add Stock</button>
      </form>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import { useClothingStore } from "@/stores/clothingStore";

export default {
  name: "AddStockModal",
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
    const stock = ref(0);

    const addStock = async () => {
      try {
        const store = useClothingStore();
        await store.addStock(props.pakaianId, stock.value);
        alert("Stock added successfully!");
        emit("stockAdded"); // Emit event after adding stock
        closeModal();
      } catch (error) {
        console.error("Failed to add stock:", error);
        alert("Failed to add stock.");
      }
    };

    const closeModal = () => {
      emit("close");
    };

    return {
      stock,
      addStock,
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

input[type="number"] {
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