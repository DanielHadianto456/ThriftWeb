<template>
  <Sidebar />
  <div :class="['wrapper', { 'wrapper-mobile': isMobile }]">
    <div class="header-container">
      <div class="title-container">
        <h1>Admin Dashboard</h1>
        <h2>Manage Your Application</h2>
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
import Sidebar from "../../Sidebar.vue";

export default {
  name: "AdminDashboard",
  components: {
    Sidebar,
  },
  setup() {
    const userCount = ref(0);
    const transactionCount = ref(0);
    const clothingCount = ref(0);
    const categoryCount = ref(0);
    const isMobile = ref(window.innerWidth <= 768);

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

    onMounted(() => {
      fetchUserCount();
      fetchTransactionCount();
      fetchClothingCount();
      fetchCategoryCount();
      window.addEventListener('resize', () => {
        isMobile.value = window.innerWidth <= 768;
      });
    });

    return {
      userCount,
      transactionCount,
      clothingCount,
      categoryCount,
      isMobile,
    };
  },
};
</script>

<style scoped>
.wrapper {
  padding: 1rem;
  margin-left: 250px; /* Set to sidebar width */
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