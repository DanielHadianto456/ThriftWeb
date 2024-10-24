<template>
  <div class="nav">
    <div class="hero">
      <h1>GrimmCafe</h1>
    </div>
    <div></div>
    <div class="items" v-if="username">
      <span class="item">Welcome, {{ username }}</span>
      <router-link class="item" to="/">Home</router-link>
      <router-link v-if="role === 'ADMIN'" class="item" to="/admin">Admin Panel</router-link>
      <span @click="logout" class="item">Logout</span>
    </div>
    <div class="items" v-else>
      <router-link to="/login" class="item">Login</router-link>
    </div>
  </div>
</template>

<script>
import { useUserStore } from "@/stores/userStore";
import { useLogout } from "@/stores/auth";

export default {
  name: "Header",
  data() {
    return {
      username: null,
      role: null,
    };
  },
  methods: {
    fetchUserData() {
      try {
        const store = useUserStore();
        this.username = store.username;
        this.role = store.role;
      } catch (error) {
        console.error("Failed to fetch user data:", error);
      }
    },
    async logout() {
      try {
        const logoutStore = useLogout();
        await logoutStore.authenticate("logout");
        const userStore = useUserStore();
        userStore.$reset();
        localStorage.removeItem("token");
        this.$router.push({ name: "Login" });
      } catch (error) {
        console.error("Failed to logout:", error);
      }
    },
  },
  mounted() {
    this.fetchUserData();
  },
};
</script>

<style scoped>
.nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #333;
  color: white;
}

.hero h1 {
  margin: 0;
}

.items {
  display: flex;
  align-items: center;
}

.item {
  margin-left: 1rem;
  cursor: pointer;
}

.item:hover {
  text-decoration: underline;
}
</style>