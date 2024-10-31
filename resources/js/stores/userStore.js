import { defineStore } from "pinia";
import {jwtDecode} from "jwt-decode";

export const useUserStore = defineStore("userStore", {
  state: () => ({
    user_id: null,
    role: null,
    username: null,
  }),

  actions: {
    setUserFromToken(token) {
      try {
        const decodedToken = jwtDecode(token);
        this.user_id = decodedToken.user_id;
        this.role = decodedToken.role;
        this.username = decodedToken.username;
        console.log("Decoded token:", decodedToken);
        console.log("User store after decoding token:", {
          user_id: this.user_id,
          role: this.role,
          username: this.username,
        });
      } catch (error) {
        console.error("Failed to decode token:", error);
      }
    },
    loadUserFromLocalStorage() {
      const token = localStorage.getItem("token");
      if (token) {
        this.setUserFromToken(token);
      }
    },

    async getProfile() {
      try {
        const response = await fetch("/api/settings/profile", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        });
        const data = await response.json();
        if (data.status) {
          this.user = data.data;
          return this.user;
        } else {
          throw new Error(data.message);
        }
      } catch (error) {
        console.error("Failed to fetch profile:", error);
        throw error;
      }
    },
    async updateProfile(formData) {
      try {
        const response = await fetch("/api/settings/update-profile", {
          method: "POST",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
          body: formData,
        });
        const data = await response.json();
        if (!response.ok) {
          throw new Error(data.message || "Failed to update profile");
        }
        return data;
      } catch (error) {
        console.error("Failed to update profile:", error);
        throw error;
      }
    },
    async resetPassword(formData) {
      try {
        const response = await fetch("/api/settings/reset-password", {
          method: "POST",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
          body: formData,
        });
        const data = await response.json();
        if (!response.ok) {
          throw new Error(data.message || "Failed to reset password");
        }
        return data;
      } catch (error) {
        console.error("Failed to reset password:", error);
        throw error;
      }
    },
  },
});