<template>
  <div class="login-page">
    <h1>Login</h1>
    <form @submit.prevent="login">
      <div>
        <label for="username">Username:</label>
        <input type="text" v-model="username" id="username" required />
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" v-model="password" id="password" required />
      </div>
      <button type="submit">Login</button>
    </form>
    <div>
      <router-link to="/register">Don't have an account? Register here.</router-link>
    </div>
  </div>
</template>

<script>
import { useAuthStore } from "@/stores/auth";

export default {
  name: "LoginPage",
  data() {
    return {
      username: "",
      password: "",
    };
  },
  methods: {
    async login() {
      const store = useAuthStore();
      const formData = {
        user_username: this.username,
        user_password: this.password,
      };
      try {
        await store.login("login", formData);
      } catch (error) {
        console.error("Login failed:", error);
      }
    },
  },
};
</script>

<style scoped>
.login-page {
  max-width: 400px;
  margin: 0 auto;
  padding: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.login-page h1 {
  text-align: center;
}

.login-page form {
  display: flex;
  flex-direction: column;
}

.login-page form div {
  margin-bottom: 1rem;
}

.login-page form label {
  margin-bottom: 0.5rem;
  font-weight: bold;
}

.login-page form input {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.login-page form button {
  padding: 0.5rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.login-page form button:hover {
  background-color: #0056b3;
}
</style>