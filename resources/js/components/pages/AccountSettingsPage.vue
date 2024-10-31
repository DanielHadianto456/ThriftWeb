<template>
  <div>
    <Sidebar v-if="role === 'ADMIN'" />
    <Header v-else />
    <div class="account-settings-page">
      <h1>Account Settings</h1>
      <div class="settings-options">
        <router-link to="/settings/update-profile" class="settings-option">
          <div class="option-card">
            <h2>Profile Settings</h2>
            <p>Update your profile information</p>
          </div>
        </router-link>
        <router-link to="/settings/reset-password" class="settings-option">
          <div class="option-card">
            <h2>Reset Password</h2>
            <p>Change your account password</p>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import Sidebar from "../Sidebar.vue";
import Header from "../Header.vue";
import { useUserStore } from "@/stores/userStore";

export default {
  name: "AccountSettingsPage",
  components: {
    Sidebar,
    Header,
  },
  setup() {
    const role = ref(null);

    const fetchUserRole = async () => {
      try {
        const store = useUserStore();
        const data = await store.getProfile();
        role.value = data.user_level;
      } catch (error) {
        console.error("Failed to fetch user role:", error);
      }
    };

    onMounted(() => {
      fetchUserRole();
    });

    return {
      role,
    };
  },
};
</script>

<style scoped>
.account-settings-page {
  max-width: 800px;
  margin: 0 auto;
  padding: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.account-settings-page h1 {
  text-align: center;
}
.settings-options {
  display: flex;
  justify-content: space-around;
  margin-top: 2rem;
}
.settings-option {
  text-decoration: none;
  color: inherit;
}
.option-card {
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 2rem;
  text-align: center;
  transition: background-color 0.3s ease;
}
.option-card:hover {
  background-color: #e9e9e9;
}
.option-card h2 {
  margin: 0 0 1rem 0;
}
.option-card p {
  margin: 0;
}
</style>