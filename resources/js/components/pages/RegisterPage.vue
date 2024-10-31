<template>
  <div class="register-page">
    <div class="register-box">
      <h1>Register</h1>
      <form @submit.prevent="register">
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" v-model="username" id="username" required />
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" v-model="password" id="password" required />
        </div>
        <div class="form-group">
          <label for="fullname">Full Name:</label>
          <input type="text" v-model="fullname" id="fullname" required />
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" v-model="email" id="email" required />
        </div>
        <div class="form-group">
          <label for="nohp">Phone Number:</label>
          <input type="text" v-model="nohp" id="nohp" required />
        </div>
        <div class="form-group">
          <label for="alamat">Address:</label>
          <input type="text" v-model="alamat" id="alamat" required />
        </div>
        <div class="form-group">
          <label for="profil_url">Profile Image:</label>
          <input type="file" @change="handleFileUpload" id="profil_url" required />
        </div>
        <button type="submit">Register</button>
      </form>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import { useRegister } from "@/stores/auth";

export default {
  name: "RegisterPage",
  setup() {
    const username = ref("");
    const password = ref("");
    const fullname = ref("");
    const email = ref("");
    const nohp = ref("");
    const alamat = ref("");
    const profil_url = ref(null);

    const handleFileUpload = (event) => {
      profil_url.value = event.target.files[0];
    };

    const register = async () => {
      const store = useRegister();
      const formData = new FormData();
      formData.append("user_username", username.value);
      formData.append("user_password", password.value);
      formData.append("user_fullname", fullname.value);
      formData.append("user_email", email.value);
      formData.append("user_nohp", nohp.value);
      formData.append("user_alamat", alamat.value);
      formData.append("user_profil_url", profil_url.value);

      try {
        await store.authenticate("register", formData);
      } catch (error) {
        console.error("Registration failed:", error);
      }
    };

    return {
      username,
      password,
      fullname,
      email,
      nohp,
      alamat,
      profil_url,
      handleFileUpload,
      register,
    };
  },
};
</script>

<style scoped>
.register-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f5f5f5;
  padding: 3rem; /* Add padding to create space around the card */
}

.register-box {
  background-color: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
  text-align: center;
}

.register-box h1 {
  margin-bottom: 1.5rem;
}

.form-group {
  margin-bottom: 1rem;
  text-align: left;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: bold;
}

.form-group input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  width: 100%;
  padding: 0.75rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
}

button:hover {
  background-color: #0056b3;
}
</style>