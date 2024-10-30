<template>
  <div class="sidebar">
    <div class="sidebar-header">
      <h1>Thrift Admin</h1>
    </div>
    <div class="sidebar-items">
      <router-link class="sidebar-item" to="/admin">Admin Dashboard</router-link>
      <router-link class="sidebar-item" to="/admin/add-clothing">Add Clothing</router-link>
      <router-link class="sidebar-item" to="/admin/add-category">Add Category</router-link>
      <router-link class="sidebar-item" to="/admin/all-transactions">All Transactions</router-link>
      <span @click="logout" class="sidebar-item">Logout</span>
    </div>
  </div>
</template>

<script>
import { useUserStore } from "@/stores/userStore";
import { useLogout } from "@/stores/auth";

export default {
  name: "Sidebar",
  methods: {
    async logout() {
      try {
        const logoutStore = useLogout();
        await logoutStore.authenticate("logout");
        const userStore = useUserStore();
        userStore.$reset();
        localStorage.removeItem("token");
        this.$router.push({ name: "login" });
      } catch (error) {
        console.error("Failed to logout:", error);
      }
    },
  },
};
</script>

<style scoped>
.sidebar {
  width: 250px;
  height: 100vh;
  background-color: #333;
  color: white;
  display: flex;
  flex-direction: column;
  position: fixed;
}

.sidebar-header {
  padding: 1rem;
  background-color: #444;
  text-align: center;
}

.sidebar-items {
  flex: 1;
  display: flex;
  flex-direction: column;
  padding: 1rem;
  padding-left: 2rem; /* Add space to the left side */
  list-style-type: disc; /* Add bullets */
}

.sidebar-item {
  margin-bottom: 1.5rem; /* Increase gap between items */
  cursor: pointer;
  color: white;
  text-decoration: none;
  display: list-item; /* Display as list item to show bullets */
}

.sidebar-item:hover {
  text-decoration: underline;
}

.sidebar-item:active,
.sidebar-item:focus,
.sidebar-item:visited {
  color: white;
  text-decoration: none;
}
</style>