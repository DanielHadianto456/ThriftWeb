import { defineStore } from "pinia";

export const useCategoryStore = defineStore("categoryStore", {
  state: () => ({
    categories: [],
  }),
  actions: {
    async fetchCategories() {
      try {
        const token = localStorage.getItem("token");
        const response = await fetch("/api/admin/kategori", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        const data = await response.json();
        if (data.status) {
          this.categories = data.data;
        } else {
          throw new Error(data.message);
        }
      } catch (error) {
        console.error("Failed to fetch categories:", error);
        throw error;
      }
    },
    async addCategory(category) {
      try {
        const token = localStorage.getItem("token");
        const response = await fetch("/api/admin/kategori/add", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
          body: JSON.stringify(category),
        });
        const data = await response.json();
        if (!response.ok) {
          throw new Error(data.message || "Failed to add category");
        }
        return data;
      } catch (error) {
        console.error("Failed to add category:", error);
        throw error;
      }
    },
  },
});