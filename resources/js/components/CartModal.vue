<template>
  <div v-if="isOpen" class="modal">
    <div class="modal-content">
      <button class="close-modal-button" @click="closeModal">&times;</button>
      <h2>Your Cart</h2>
      <div v-if="cartItems.length === 0">
        <p>Your cart is empty.</p>
      </div>
      <div v-else>
        <div v-for="item in cartItems" :key="item.pakaian_id" class="cart-item">
          <img :src="`/storage/${item.pakaian_gambar_url}`" alt="Clothing Image" />
          <div class="item-details">
            <h3>{{ item.pakaian_nama }}</h3>
            <p>Harga: Rp. {{ item.pakaian_harga.toLocaleString("id-ID") }}</p>
            <p>Jumlah: {{ item.jumlah }}</p>
            <p>Stok Tersisa: {{ item.pakaian_stok }}</p>
            <button @click="removeFromCart(item.pakaian_id)">Remove</button>
          </div>
        </div>
        <div class="total">
          <h3>Total: Rp. {{ totalPrice.toLocaleString("id-ID") }}</h3>
        </div>
        <div class="payment-method">
          <h3>Select Payment Method</h3>
          <select v-model="paymentMethod">
            <option value="OVO">OVO</option>
            <option value="DANA">DANA</option>
            <option value="BCA">BCA</option>
            <option value="COD">COD</option>
          </select>
          <div v-if="paymentMethod !== 'COD'">
            <label for="paymentNumber">Payment Number:</label>
            <input type="text" v-model="paymentNumber" id="paymentNumber" />
          </div>
        </div>
        <button @click="checkout">Checkout</button>
      </div>
    </div>
  </div>
</template>

<script>
import { computed, ref } from "vue";
import { useCartStore } from "@/stores/cartStore";

export default {
  name: "CartModal",
  setup() {
    const cartStore = useCartStore();
    const paymentMethod = ref("COD");
    const paymentNumber = ref("");

    const checkout = async () => {
      try {
        await cartStore.checkout(paymentMethod.value, paymentNumber.value);
        alert("Checkout successful!");
        cartStore.closeCart();
      } catch (error) {
        console.error("Checkout failed:", error);
        alert("Checkout failed. Please try again.");
      }
    };

    return {
      isOpen: computed(() => cartStore.isOpen),
      cartItems: computed(() => cartStore.items),
      totalPrice: computed(() => cartStore.items.reduce((total, item) => total + item.pakaian_harga * item.jumlah, 0)),
      closeModal: cartStore.closeCart,
      removeFromCart: cartStore.removeFromCart,
      checkout,
      paymentMethod,
      paymentNumber,
    };
  },
};
</script>

<style scoped>
.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  width: 80%;
  max-width: 600px;
}

.close {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
}

.cart-item {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.cart-item img {
  width: 80px;
  height: 80px;
  margin-right: 10px;
}

.item-details {
  flex: 1;
}

.total {
  margin-top: 20px;
  font-weight: bold;
}

.payment-method {
  margin-top: 20px;
}

.payment-method select,
.payment-method input {
  display: block;
  margin-top: 10px;
  padding: 5px;
  width: 100%;
  box-sizing: border-box;
}
</style>