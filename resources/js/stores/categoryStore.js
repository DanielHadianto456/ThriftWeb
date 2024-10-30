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
  },
});