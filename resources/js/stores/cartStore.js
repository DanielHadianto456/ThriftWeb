import { defineStore } from "pinia";

export const useCartStore = defineStore("cartStore", {
  state: () => ({
    items: [],
    isOpen: false,
  }),
  actions: {
    addToCart(item) {
      const existingItem = this.items.find(i => i.pakaian_id === item.pakaian_id);
      if (existingItem) {
        existingItem.jumlah += item.jumlah;
        existingItem.pakaian_stok -= item.jumlah;
      } else {
        this.items.push({ ...item, pakaian_stok: item.pakaian_stok - item.jumlah });
      }
    },
    removeFromCart(pakaian_id) {
      const item = this.items.find(i => i.pakaian_id === pakaian_id);
      if (item) {
        item.pakaian_stok += item.jumlah;
        this.items = this.items.filter(i => i.pakaian_id !== pakaian_id);
      }
    },
    openCart() {
      this.isOpen = true;
    },
    closeCart() {
      this.isOpen = false;
    },
    async checkout(paymentMethod, paymentNumber) {
      const token = localStorage.getItem("token");

      if (!token) {
        throw new Error("No token found. Please log in.");
      }

      const res = await fetch("/api/user/pembelian/add", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
          metode_pembayaran_jenis: paymentMethod,
          metode_pembayaran_nomor: paymentMethod === "COD" ? null : paymentNumber,
          items: this.items.map(item => ({
            pakaian_id: item.pakaian_id,
            jumlah: item.jumlah,
          })),
        }),
      });

      const data = await res.json();

      if (res.ok) {
        this.items = [];
        await this.confirmTransaction(data.data.pembelian_id);
      } else {
        throw new Error(data.message || "Checkout failed");
      }
    },
    async confirmTransaction(pembelian_id) {
      const token = localStorage.getItem("token");

      if (!token) {
        throw new Error("No token found. Please log in.");
      }

      const res = await fetch(`/api/user/pembelian/confirm/${pembelian_id}`, {
        method: "PATCH",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: `Bearer ${token}`,
        },
      });

      const data = await res.json();

      if (!res.ok) {
        throw new Error(data.message || "Failed to confirm transaction");
      }
    },
  },
});