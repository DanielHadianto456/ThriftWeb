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
      <span @click="logout" class="item">Logout</span>
    </div>
    <div class="items" v-else>
      <router-link to="/login" class="item">Login</router-link>
    </div>
    <button class="toggle-button" @click="toggleMenu">☰</button>
    <div :class="['mobile-menu', { 'mobile-menu-open': isMenuOpen }]">
      <div v-if="username" class="mobile-user-info">
        <img :src="profileImageUrl" alt="Profile Image" class="mobile-profile-image" />
        <span class="mobile-item">Welcome, {{ username }}</span>
      </div>
      <router-link class="mobile-item" to="/" @click="toggleMenu">Home</router-link>
      <router-link class="mobile-item" to="/user/HistoryPage" @click="toggleMenu">History</router-link>
      <router-link class="mobile-item" to="/settings" @click="toggleMenu">Settings</router-link>
      <span @click="logout" class="mobile-item">Logout</span>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import { useUserStore } from "@/stores/userStore";
import { useLogout } from "@/stores/auth";

export default {
  name: "Header",
  data() {
    return {
      username: null,
      role: null,
      profileImageUrl: null,
      isMenuOpen: false,
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
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
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
  font-family: 'Poppins', sans-serif;
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
  color: white;
  text-decoration: none;
}
.item:hover {
  text-decoration: underline;
}
.item:active,
.item:focus,
.item:visited {
  color: white;
  text-decoration: none;
}
.router-link-active {
  color: white;
}
.profile-image {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 0.5rem;
}
.toggle-button {
  display: none;
  background-color: #333;
  color: white;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}
.mobile-menu {
  display: none;
  flex-direction: column;
  align-items: center;
  background-color: #333;
  position: absolute;
  top: 60px;
  left: 0;
  width: 100%;
  z-index: 1000;
}
.mobile-menu-open {
  display: flex;
}
.mobile-item {
  padding: 1rem;
  color: white;
  text-decoration: none;
  width: 100%;
  text-align: center;
}
.mobile-item:hover {
  background-color: #444;
}
.mobile-user-info {
  display: flex;
  align-items: center;
  padding: 1rem;
  border-bottom: 1px solid #444;
  width: 100%;
  justify-content: center;
}
.mobile-profile-image {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 0.5rem;
}
@media (max-width: 768px) {
  .items {
    display: none;
  }
  .toggle-button {
    display: block;
  }
}
</style>