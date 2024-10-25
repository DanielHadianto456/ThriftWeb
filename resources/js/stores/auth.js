import { defineStore } from "pinia";
import {jwtDecode} from "jwt-decode";
import { useUserStore } from "./userStore";

export const useRegister = defineStore("registerStore", {
    state: () => {
        return {
            user: null,
        };
    },

    // getters: {},

    actions: {
        async authenticate(apiRoute, formData) {
            const res = await fetch(`/api/${apiRoute}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json", // Added header
                    Accept: "application/json",
                },
                body: JSON.stringify(formData),
            });

            const data = await res.json();

            if (res.ok) {
                console.log(data);
                this.router.push({ name: "Home" });
                // alert("error.message");
            } else {
                alert("Username sudah ada");
            }
        },
    },
});

// export const useAuthStore = defineStore("authStore", {
//   state: () => ({
//     token: null,
//   }),

//   actions: {
//     async login(apiRoute, formData) {
//       try {
//         const res = await fetch(`/api/${apiRoute}`, {
//           method: "POST",
//           headers: {
//             "Content-Type": "application/json",
//             Accept: "application/json",
//           },
//           body: JSON.stringify(formData),
//         });

//         const data = await res.json();

//         if (res.ok) {
//           localStorage.setItem("token", data.token);
//           this.token = data.token;

//           // Use the user store to set the role and username
//           const userStore = useUserStore();
//           userStore.setUserFromToken(data.token);

//           this.router.push({ name: "Home" });
//         } else {
//           console.error("Login failed:", data.message);
//           alert("Unauthorized");
//         }
//       } catch (error) {
//         console.error("An error occurred:", error);
//         alert("An error occurred: " + error.message);
//       }
//     },
//   },
// });

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

// export const useLogout = defineStore("logoutStore", {
//   actions: {
//       async authenticate(apiRoute) {
//           const token = localStorage.getItem("token"); // Get the token from local storage

//           const res = await fetch(`/api/${apiRoute}`, {
//               method: "POST",
//               headers: {
//                   "Content-Type": "application/json",
//                   Accept: "application/json",
//                   Authorization: `Bearer ${token}`, // Send the token in the Authorization header
//               },
//           });

//           const data = await res.json();

//           if (data) {
//               localStorage.removeItem("token");
//               this.router.push({ name: "Login" });
//           } else {
//               console.error("Failed to logout");
//           }
//       },
//   },
// });

// export const useAuthStore = defineStore("authStore", {
//     state: () => ({
//       token: null,
//     }),
  
//     actions: {
//       async login(apiRoute, formData) {
//         try {
//           const res = await fetch(`/api/${apiRoute}`, {
//             method: "POST",
//             headers: {
//               "Content-Type": "application/json",
//               Accept: "application/json",
//             },
//             body: JSON.stringify(formData),
//           });
  
//           const data = await res.json();
  
//           if (res.ok) {
//             localStorage.setItem("token", data.token);
//             this.token = data.token;
  
//             // Use the user store to set the role
//             const userStore = useUserStore();
//             userStore.setRoleFromToken(data.token);
  
//             this.router.push({ name: "Home" });
//           } else {
//             console.error("Login failed:", data.message);
//             alert("Unauthorized");
//           }
//         } catch (error) {
//           console.error("An error occurred:", error);
//           alert("An error occurred: " + error.message);
//         }
//       },
//     },
//   });

// export const useLogin = defineStore("loginStore", {
//     state: () => ({
//         user: null,
//         token: null,
//         role: null,
//     }),

//     actions: {
//         async authenticate(apiRoute, formData) {
//             try {
//                 const res = await fetch(`/api/${apiRoute}`, {
//                     method: "POST",
//                     headers: {
//                         "Content-Type": "application/json",
//                         Accept: "application/json",
//                     },
//                     body: JSON.stringify(formData),
//                 });

//                 const data = await res.json();

//                 if (res.ok) {
//                     localStorage.setItem("token", data.token);
//                     this.token = data.token;

//                     // Decode the token to get the role
//                     const decodedToken = jwtDecode(data.token);
//                     console.log("Decoded Token:", decodedToken); // Add this line
//                     this.role = decodedToken.role;
//                     console.log("Role set in store:", this.role);

//                     this.router.push({ name: "Home" });
//                 } else {
//                     console.error("Login failed:", data.message);
//                     alert("Unauthorized");
//                 }
//             } catch (error) {
//                 console.error("An error occurred:", error);
//                 alert("An error occurred: " + error.message);
//             }
//         },
//     },
// });

// export const useLogin = defineStore("loginStore", {
//     state: () => ({
//     //   user: null,
//       token: null,
//       role: null,
//     }),

//     actions: {
//       async authenticate(apiRoute, formData) {
//         try {
//           const res = await fetch(`/api/${apiRoute}`, {
//             method: "POST",
//             headers: {
//               "Content-Type": "application/json",
//               Accept: "application/json",
//             },
//             body: JSON.stringify(formData),
//           });

//           const data = await res.json();

//           if (res.ok) {
//             localStorage.setItem("token", data.token);
//             this.token = data.token;

//             // Decode the token to get the role
//             const decodedToken = jwtDecode(data.token);
//             this.role = decodedToken.role;

//             this.router.push({ name: "Home" });
//           } else {
//             console.error("Login failed:", data.message);
//             alert("Unauthorized");
//           }
//         } catch (error) {
//           console.error("An error occurred:", error);
//           alert("An error occurred: " + error.message);
//         }
//       },
//     },
//   });

// export const useLogin = defineStore("loginStore", {
//     state: () => {
//         return {
//             user: null,

//             // token: data.token
//         };
//     },

//     // getters: {},

//     actions: {
//         async authenticate(apiRoute, formData) {
//             try {
//                 const res = await fetch(`/api/${apiRoute}`, {
//                     method: "POST",
//                     headers: {
//                         "Content-Type": "application/json",
//                         Accept: "application/json",
//                     },
//                     body: JSON.stringify(formData),
//                 });

//                 const data = await res.json();

//                 if (res.ok) {
//                     localStorage.setItem("token", data.token);

//                     this.token = data.token;

//                     this.router.push({ name: "Home" });
//                 } else {
//                     // Handle error response
//                     console.error("Login failed:", data.message);
//                     alert("Unauthorized"); // Display error message to the user
//                 }
//             } catch (error) {
//                 console.error("An error occurred:", error);
//                 alert("An error occurred: " + error.message); // Display error message to the user
//             }
//         },
//     },
// });
