import { defineStore } from 'pinia';

export const useAdminStore = defineStore('adminStore', {
  actions: {
    async getAllUsers() {
      try {
        const response = await fetch('/api/admin/users', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        const data = await response.json();
        if (data.status) {
          return data.data;
        } else {
          throw new Error(data.message);
        }
      } catch (error) {
        console.error('Failed to fetch users:', error);
        throw error;
      }
    },
    async getAllTransactions() {
      try {
        const response = await fetch('/api/admin/pembelian', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        const data = await response.json();
        if (data.status) {
          return data.data;
        } else {
          throw new Error(data.message);
        }
      } catch (error) {
        console.error('Failed to fetch transactions:', error);
        throw error;
      }
    },
    async getAllClothing() {
      try {
        const response = await fetch('/api/admin/pakaian', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        const data = await response.json();
        if (data.status) {
          return data.data;
        } else {
          throw new Error(data.message);
        }
      } catch (error) {
        console.error('Failed to fetch clothing:', error);
        throw error;
      }
    },
    async getAllCategories() {
      try {
        const response = await fetch('/api/admin/kategori', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          },
        });
        const data = await response.json();
        if (data.status) {
          return data.data;
        } else {
          throw new Error(data.message);
        }
      } catch (error) {
        console.error('Failed to fetch categories:', error);
        throw error;
      }
    },
  },
});