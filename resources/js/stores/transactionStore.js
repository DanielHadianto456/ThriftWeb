import { defineStore } from "pinia";

export const getAllTransaction = defineStore("getAllTransactionStore", {
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

export const getTransactionId = defineStore("getTransactionIdStore", {
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

export const useTransactionStore = defineStore("transactionStore", {
    actions: {
      async getAllTransactions() {
        try {
          const token = localStorage.getItem("token");
          const response = await fetch("/api/admin/pembelian", {
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
          console.error("Failed to fetch transactions:", error);
          throw error;
        }
      },
    },
  });