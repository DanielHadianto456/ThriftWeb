<template>
  <div>
    <Sidebar v-if="role === 'ADMIN'" />
    <Header v-else />
    <div class="profile-settings-page">
      <h1>User Profile Settings</h1>
      <form @submit.prevent="updateProfile">
        <div>
          <label for="fullname">Full Name:</label>
          <input type="text" v-model="fullname" id="fullname" />
        </div>
        <div>
          <label for="username">Username:</label>
          <input type="text" v-model="username" id="username" />
        </div>
        <div>
          <label for="email">Email:</label>
          <input type="email" v-model="email" id="email" />
        </div>
        <div>
          <label for="nohp">Phone Number:</label>
          <input type="text" v-model="nohp" id="nohp" />
        </div>
        <div>
          <label for="alamat">Address:</label>
          <input type="text" v-model="alamat" id="alamat" />
        </div>
        <div>
          <label for="profil_url">Profile Image:</label>
          <input type="file" @change="handleFileUpload" id="profil_url" />
        </div>
        <button type="submit">Update Profile</button>
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
  name: "UserProfileSettings",
  components: {
    Sidebar,
    Header,
  },
  setup() {
    const fullname = ref("");
    const username = ref("");
    const email = ref("");
    const nohp = ref("");
    const alamat = ref("");
    const profil_url = ref(null);
    const role = ref(null);

    const handleFileUpload = (event) => {
      profil_url.value = event.target.files[0];
    };

    const fetchUserRole = async () => {
      try {
        const store = useUserStore();
        const data = await store.getProfile();
        role.value = data.user_level;
      } catch (error) {
        console.error("Failed to fetch user role:", error);
      }
    };

    const fetchProfile = async () => {
      try {
        const store = useUserStore();
        const data = await store.getProfile();
        fullname.value = data.user_fullname;
        username.value = data.user_username;
        email.value = data.user_email;
        nohp.value = data.user_nohp;
        alamat.value = data.user_alamat;
      } catch (error) {
        console.error("Failed to fetch profile:", error);
      }
    };

    const updateProfile = async () => {
      const store = useUserStore();
      const formData = new FormData();
      formData.append("user_fullname", fullname.value);
      formData.append("user_username", username.value);
      formData.append("user_email", email.value);
      formData.append("user_nohp", nohp.value);
      formData.append("user_alamat", alamat.value);
      if (profil_url.value) {
        formData.append("user_profil_url", profil_url.value);
      }

      try {
        await store.updateProfile(formData);
        alert("Profile updated successfully!");
      } catch (error) {
        console.error("Failed to update profile:", error);
        alert("Failed to update profile.");
      }
    };

    onMounted(() => {
      fetchUserRole();
      fetchProfile();
    });

    return {
      fullname,
      username,
      email,
      nohp,
      alamat,
      profil_url,
      handleFileUpload,
      updateProfile,
      role,
    };
  },
};
</script>

<style scoped>
.profile-settings-page {
  max-width: 600px;
  margin: 0 auto;
  padding: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.profile-settings-page h1 {
  text-align: center;
}
.profile-settings-page form {
  display: flex;
  flex-direction: column;
}
.profile-settings-page form div {
  margin-bottom: 1rem;
}
.profile-settings-page form label {
  margin-bottom: 0.5rem;
  font-weight: bold;
}
.profile-settings-page form input {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.profile-settings-page form button {
  padding: 0.5rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.profile-settings-page form button:hover {
  background-color: #0056b3;
}
</style>