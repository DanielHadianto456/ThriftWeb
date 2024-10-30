import { defineStore } from "pinia";

export const getAllClothing = defineStore("getAllClothingStore", {
  actions: {
    async authenticate(apiRoute) {
      const token = localStorage.getItem("token");

      const res = await fetch(`/api/${apiRoute}`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: `Bearer ${token}`,
        },
      });

      const data = await res.json();
      console.log(data);
      return data;
    },
  },
});

export const useClothingStore = defineStore("clothingStore", {
  actions: {
    async addClothing(formData) {
      try {
        const token = localStorage.getItem("token");
        const response = await fetch("/api/admin/pakaian/add", {
          method: "POST",
          headers: {
            Authorization: `Bearer ${token}`,
          },
          body: formData,
        });
        const data = await response.json();
        if (!response.ok) {
          throw new Error(data.message || "Failed to add clothing item");
        }
        return data;
      } catch (error) {
        console.error("Failed to add clothing item:", error);
        throw error;
      }
    },
    async getAllClothing() {
        try {
          const token = localStorage.getItem("token");
          const response = await fetch("/api/admin/pakaian", {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          const data = await response.json();
          if (data.status) {
            return data.data;
          } else {
            throw new Error(data.message);
          }
        } catch (error) {
          console.error("Failed to fetch clothing items:", error);
          throw error;
        }
      },
      async addStock(pakaian_id, stock) {
        try {
          const token = localStorage.getItem("token");
          const response = await fetch(`/api/admin/pakaian/add-stock/${pakaian_id}`, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({ pakaian_stok: stock }),
          });
          const data = await response.json();
          if (!response.ok) {
            throw new Error(data.message || "Failed to add stock");
          }
          return data;
        } catch (error) {
          console.error("Failed to add stock:", error);
          throw error;
        }
      },
      async editClothing(pakaian_id, formData) {
        try {
          const token = localStorage.getItem("token");
          const response = await fetch(`/api/admin/pakaian/edit/${pakaian_id}`, {
            method: "POST",
            headers: {
              Authorization: `Bearer ${token}`,
            },
            body: formData,
          });
          const data = await response.json();
          if (!response.ok) {
            throw new Error(data.message || "Failed to edit clothing item");
          }
          return data;
        } catch (error) {
          console.error("Failed to edit clothing item:", error);
          throw error;
        }
      },
  },
});