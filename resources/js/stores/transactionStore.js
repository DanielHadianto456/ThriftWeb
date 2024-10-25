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