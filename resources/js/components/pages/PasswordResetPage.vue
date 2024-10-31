<template>
  <div>
    <Sidebar v-if="role === 'ADMIN'" />
    <Header v-else />
    <div class="password-reset-page">
      <h1>Reset Password</h1>
      <form @submit.prevent="resetPassword">
        <div>
          <label for="current_password">Current Password:</label>
          <input type="password" v-model="currentPassword" id="current_password" required />
        </div>
        <div>
          <label for="new_password">New Password:</label>
          <input type="password" v-model="newPassword" id="new_password" minlength="8" required />
        </div>
        <div>
          <label for="new_password_confirmation">Confirm New Password:</label>
          <input type="password" v-model="newPasswordConfirmation" id="new_password_confirmation" minlength="8" required />
        </div>
        <button type="submit">Reset Password</button>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useUserStore } from "@/stores/userStore";
import Sidebar from "../Sidebar.vue";
import Header from "../Header.vue";

export default {
  name: "PasswordResetPage",
  components: {
    Sidebar,
    Header,
  },
  setup() {
    const currentPassword = ref("");
    const newPassword = ref("");
    const newPasswordConfirmation = ref("");
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

    const resetPassword = async () => {
      const store = useUserStore();
      const formData = new FormData();
      formData.append("current_password", currentPassword.value);
      formData.append("new_password", newPassword.value);
      formData.append("new_password_confirmation", newPasswordConfirmation.value);

      try {
        await store.resetPassword(formData);
        alert("Password reset successfully!");
      } catch (error) {
        console.error("Failed to reset password:", error);
        alert("Failed to reset password.");
      }
    };

    onMounted(() => {
      fetchUserRole();
    });

    return {
      currentPassword,
      newPassword,
      newPasswordConfirmation,
      resetPassword,
      role,
    };
  },
};
</script>

<style scoped>
.password-reset-page {
  max-width: 400px;
  margin: 0 auto;
  padding: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.password-reset-page h1 {
  text-align: center;
}
.password-reset-page form {
  display: flex;
  flex-direction: column;
}
.password-reset-page form div {
  margin-bottom: 1rem;
}
.password-reset-page form label {
  margin-bottom: 0.5rem;
  font-weight: bold;
}
.password-reset-page form input {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.password-reset-page form button {
  padding: 0.5rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.password-reset-page form button:hover {
  background-color: #0056b3;
}
</style>