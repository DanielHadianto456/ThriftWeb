<template>
  <div class="register-page">
    <h1>Register</h1>
    <form @submit.prevent="register">
      <div>
        <label for="username">Username:</label>
        <input type="text" v-model="username" id="username" required />
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" v-model="password" id="password" required />
      </div>
      <div>
        <label for="fullname">Full Name:</label>
        <input type="text" v-model="fullname" id="fullname" required />
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" v-model="email" id="email" required />
      </div>
      <div>
        <label for="nohp">Phone Number:</label>
        <input type="text" v-model="nohp" id="nohp" required />
      </div>
      <div>
        <label for="alamat">Address:</label>
        <input type="text" v-model="alamat" id="alamat" required />
      </div>
      <div>
        <label for="profil_url">Profile Image:</label>
        <input type="file" @change="handleFileUpload" id="profil_url" required />
      </div>
      <!-- <div>
        <label for="level">Role:</label>
        <select v-model="level" id="level" required>
          <option value="ADMIN">Admin</option>
          <option value="PENGGUNA">User</option>
        </select>
      </div> -->
      <button type="submit">Register</button>
    </form>
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
    // const level = ref("PENGGUNA");

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
    //   formData.append("user_level", level.value);

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
    //   level,
      handleFileUpload,
      register,
    };
  },
};
</script>

<style scoped>
.register-page {
  max-width: 400px;
  margin: 0 auto;
  padding: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.register-page h1 {
  text-align: center;
}
.register-page form {
  display: flex;
  flex-direction: column;
}
.register-page form div {
  margin-bottom: 1rem;
}
.register-page form label {
  margin-bottom: 0.5rem;
  font-weight: bold;
}
.register-page form input,
.register-page form select {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.register-page form button {
  padding: 0.5rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.register-page form button:hover {
  background-color: #0056b3;
}
</style>