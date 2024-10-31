import { defineStore } from "pinia";
import {jwtDecode} from "jwt-decode";
import { useUserStore } from "./userStore";

export const useRegister = defineStore("registerStore", {
  state: () => {
    return {
      user: null,
    };
  },

  actions: {
    async authenticate(apiRoute, formData) {
      try {
        const res = await fetch(`/api/${apiRoute}`, {
          method: "POST",
          body: formData,
        });

        const data = await res.json();

        if (res.ok) {
          console.log(data);
          // const router = useRouter();
          this.router.push({ name: "login" });
        } else {
          alert("Username already exists");
        }
      } catch (error) {
        console.error("Registration failed:", error);
      }
    },
  },
});

export const useAuthStore = defineStore("authStore", {
  state: () => ({
    token: null,
  }),

  actions: {
    async login(apiRoute, formData) {
      try {
        const res = await fetch(`/api/${apiRoute}`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify(formData),
        });

        const data = await res.json();

        if (res.ok) {
          localStorage.setItem("token", data.token);
          this.token = data.token;

          // Use the user store to set the role and username
          const userStore = useUserStore();
          userStore.setUserFromToken(data.token);

          // console.log("Token set in auth store:", data.token);
          // console.log("User store after setting token:", {
          //   user_id: userStore.user_id,
          //   role: userStore.role,
          //   username: userStore.username,
          // });

          this.router.push({ name: "Home" });
        } else {
          console.error("Login failed:", data.message);
          alert("Unauthorized");
        }
      } catch (error) {
        console.error("An error occurred:", error);
        alert("An error occurred: " + error.message);
      }
    },
  },
});

export const useLogout = defineStore("logoutStore", {
  actions: {
    async authenticate(apiRoute) {
      try {
        const token = localStorage.getItem("token"); // Get the token from local storage

        const res = await fetch(`/api/${apiRoute}`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: `Bearer ${token}`, // Send the token in the Authorization header
          },
        });

        const data = await res.json();

        if (res.ok) {
          localStorage.removeItem("token"); // Remove the token from local storage
          this.router.push({ name: "login" }); // Redirect to the login page
        } else {
          console.error("Failed to logout:", data.message);
        }
      } catch (error) {
        console.error("An error occurred during logout:", error);
      }
    },
  },
});

