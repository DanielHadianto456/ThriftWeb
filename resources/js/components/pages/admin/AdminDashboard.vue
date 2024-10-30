<template>
  <Header />
  <div class="wrapper">
    <div class="header-container">
      <div class="title-container">
        <h1>Admin Dashboard</h1>
        <h2>Manage Your Application</h2>
      </div>
      <div class="button-container">
        <button @click="navigateToAddClothing">Add Clothing Item</button>
      </div>
    </div>
    <div class="content-container">
      <div class="card">
        <h3>Users</h3>
        <p>Total Users: {{ userCount }}</p>
      </div>
      <div class="card">
        <h3>Transactions</h3>
        <p>Total Transactions: {{ transactionCount }}</p>
      </div>
      <div class="card">
        <h3>Clothing Items</h3>
        <p>Total Clothing Items: {{ clothingCount }}</p>
      </div>
      <div class="card">
        <h3>Categories</h3>
        <p>Total Categories: {{ categoryCount }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useAdminStore } from "@/stores/adminStore";
import Header from "../../Header.vue";
import { useRouter } from "vue-router";

export default {
  name: "AdminDashboard",
  components: {
    Header,
  },
  setup() {
    const userCount = ref(0);
    const transactionCount = ref(0);
    const clothingCount = ref(0);
    const categoryCount = ref(0);
    const router = useRouter();

    const fetchUserCount = async () => {
      try {
        const store = useAdminStore();
        const data = await store.getAllUsers();
        userCount.value = data.length;
      } catch (error) {
        console.error("Failed to fetch user count:", error);
      }
    };

    const fetchTransactionCount = async () => {
      try {
        const store = useAdminStore();
        const data = await store.getAllTransactions();
        transactionCount.value = data.length;
      } catch (error) {
        console.error("Failed to fetch transaction count:", error);
      }
    };

    const fetchClothingCount = async () => {
      try {
        const store = useAdminStore();
        const data = await store.getAllClothing();
        clothingCount.value = data.length;
      } catch (error) {
        console.error("Failed to fetch clothing count:", error);
      }
    };

    const fetchCategoryCount = async () => {
      try {
        const store = useAdminStore();
        const data = await store.getAllCategories();
        categoryCount.value = data.length;
      } catch (error) {
        console.error("Failed to fetch category count:", error);
      }
    };

    const navigateToAddClothing = () => {
      router.push({ name: "AddClothing" });
    };

    onMounted(() => {
      fetchUserCount();
      fetchTransactionCount();
      fetchClothingCount();
      fetchCategoryCount();
    });

    return {
      userCount,
      transactionCount,
      clothingCount,
      categoryCount,
      navigateToAddClothing,
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

.button-container {
  display: flex;
  align-items: center;
}

button {
  padding: 0.5rem 1rem;
  background-color: #007bff;
  color: white;
  border: none;
  cursor: pointer;
  margin-left: 1rem;
}

button:hover {
  background-color: #0056b3;
}

.content-container {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 1rem;
  flex: 1;
  min-width: 200px;
}
</style>