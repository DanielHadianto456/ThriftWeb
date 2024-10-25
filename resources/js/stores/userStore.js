// import { defineStore } from "pinia";
// import {jwtDecode} from "jwt-decode";

// export const useUserStore = defineStore("userStore", {
//   state: () => ({
//     user_id: null,
//     role: null,
//     username: null,
//   }),

//   actions: {
//     setUserFromToken(token) {
//       try {
//         const decodedToken = jwtDecode(token);
//         this.user_id = decodedToken.user_id;
//         this.role = decodedToken.role;
//         this.username = decodedToken.username;
        
//         console.log("Role set in user store:", this.role);
//         console.log("id set in user store:", this.id);
//         console.log("Username set in user store:", this.username);
//       } catch (error) {
//         console.error("Failed to decode token:", error);
//       }
//     },
//   },
// });

// resources/js/stores/userStore.js
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
  },
});