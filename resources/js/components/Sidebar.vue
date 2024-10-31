<template>
  <div>
    <button class="toggle-button" @click="toggleSidebar">☰</button>
    <div :class="['sidebar', { 'sidebar-open': isSidebarOpen }]">
      <div class="sidebar-header">
        <h1>Thrift Admin</h1>
      </div>
      <div class="sidebar-items">
        <router-link class="sidebar-item" to="/admin">Dashboard</router-link>
        <router-link class="sidebar-item" to="/admin/all-categories">Categories</router-link>
        <router-link class="sidebar-item" to="/admin/all-transactions">Transactions</router-link>
        <router-link class="sidebar-item" to="/admin/all-clothing">Clothing</router-link>
        <span @click="logout" class="sidebar-item">Logout</span>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import { useUserStore } from "@/stores/userStore";
import { useLogout } from "@/stores/auth";

export default {
  name: "Sidebar",
  setup() {
    const isSidebarOpen = ref(false);

    const toggleSidebar = () => {
      isSidebarOpen.value = !isSidebarOpen.value;
    };

    const logout = async () => {
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
    };

    return {
      isSidebarOpen,
      toggleSidebar,
      logout,
    };
  },
};
</script>

<style scoped>
.sidebar {
  width: 250px; /* Increase sidebar width */
  height: 100vh;
  background-color: #333;
  color: white;
  display: flex;
  flex-direction: column;
  position: fixed;
  transform: translateX(0); /* Ensure sidebar is visible in desktop view */
  transition: transform 0.3s ease;
  z-index: 1000;
}

.sidebar-open {
  transform: translateX(0);
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
}

.sidebar-item {
  margin-bottom: 1rem;
  cursor: pointer;
  color: white;
  text-decoration: none;
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

.toggle-button {
  display: none;
  position: fixed;
  top: 1rem;
  left: 0.5rem;
  background-color: #333;
  color: white;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  z-index: 1001;
}

@media (max-width: 768px) {
  .sidebar {
    width: 300px;
    transform: translateX(-100%);
  }

  .sidebar-open {
    transform: translateX(0);
  }

  .toggle-button {
    display: block;
  }
}
</style>