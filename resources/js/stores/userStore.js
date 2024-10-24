import { defineStore } from "pinia";
import {jwtDecode} from "jwt-decode";

export const useUserStore = defineStore("userStore", {
  state: () => ({
    role: null,
  }),

  actions: {
    setRoleFromToken(token) {
      try {
        const decodedToken = jwtDecode(token);
        this.role = decodedToken.role;
        console.log("Role set in user store:", this.role);
      } catch (error) {
        console.error("Failed to decode token:", error);
      }
    },
  },
});