import { defineStore } from "pinia";
import {jwtDecode} from "jwt-decode";

export const useUserStore = defineStore("userStore", {
  state: () => ({
    role: null,
    username: null,
  }),

  actions: {
    setUserFromToken(token) {
      try {
        const decodedToken = jwtDecode(token);
        this.role = decodedToken.role;
        this.username = decodedToken.username;
        console.log("Role set in user store:", this.role);
        console.log("Username set in user store:", this.username);
      } catch (error) {
        console.error("Failed to decode token:", error);
      }
    },
  },
});