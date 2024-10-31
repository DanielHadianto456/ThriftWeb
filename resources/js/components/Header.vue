<template>
  <div class="nav">
    <div class="hero">
      <h1>Thrift</h1>
    </div>
    <div></div>
    <div class="items" v-if="username">
      <img :src="profileImageUrl" alt="Profile Image" class="profile-image" />
      <span class="item">Welcome, {{ username }}</span>
      <router-link class="item" to="/">Home</router-link>
      <router-link class="item" to="/user/HistoryPage">History</router-link>
      <router-link class="item" to="/settings">Settings</router-link>
      
      <!-- <router-link v-if="role === 'ADMIN'" class="item" to="/admin">Admin Panel</router-link> -->
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
      profileImageUrl: null,
    };
  },
  methods: {
    async fetchUserData() {
      try {
        const store = useUserStore();
        const data = await store.getProfile();
        this.username = data.user_username;
        this.role = data.user_level;
        this.profileImageUrl = `/storage/${data.user_profil_url}`;
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
        this.$router.push({ name: "login" });
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
  font-family: 'Poppins', sans-serif; /* Use Poppins font */
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
  color: white; /* Ensure text color is white */
  text-decoration: none; /* Remove underline */
}
.item:hover {
  text-decoration: underline;
}
.item:active,
.item:focus,
.item:visited {
  color: white; /* Ensure text color remains white */
  text-decoration: none; /* Remove underline */
}
.router-link-active {
  color: white; /* Ensure active link color remains white */
}
.profile-image {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 0.5rem;
}
</style>