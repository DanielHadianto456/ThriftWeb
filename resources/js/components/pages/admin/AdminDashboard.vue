<template>
  <Sidebar />
  <div :class="['wrapper', { 'wrapper-mobile': isMobile }]">
    <div class="header-container">
      <div class="title-container">
        <h1>Admin Dashboard</h1>
        <h2>Manage Your Application</h2>
      </div>
      <div class="user-info">
        <img :src="profileImageUrl" alt="Profile Image" class="profile-image" />
        <span>Welcome, {{ fullname }}</span>
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
import { useUserStore } from "@/stores/userStore";
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
    const fullname = ref("");
    const profileImageUrl = ref("");
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

    const fetchUserProfile = async () => {
      try {
        const store = useUserStore();
        const data = await store.getProfile();
        fullname.value = data.user_fullname;
        profileImageUrl.value = `/storage/${data.user_profil_url}`;
      } catch (error) {
        console.error("Failed to fetch user profile:", error);
      }
    };

    onMounted(() => {
      fetchUserCount();
      fetchTransactionCount();
      fetchClothingCount();
      fetchCategoryCount();
      fetchUserProfile();
      window.addEventListener('resize', () => {
        isMobile.value = window.innerWidth <= 768;
      });
    });

    return {
      userCount,
      transactionCount,
      clothingCount,
      categoryCount,
      fullname,
      profileImageUrl,
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
  margin-left: 0; /* No margin for mobile view */
  padding-top: 4rem;
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

.user-info {
  display: flex;
  align-items: center;
}

.profile-image {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 0.5rem;
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