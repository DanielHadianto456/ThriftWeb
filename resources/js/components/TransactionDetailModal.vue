<template>
  <div v-if="isOpen" class="modal">
    <div class="modal-content">
      <!-- Close button inside the modal content, positioned top-right -->
      <button class="close-modal-button" @click="closeModal">&times;</button>
      <h2>Transaction Details</h2>
      
      <div v-if="transaction">
        <div class="transaction-detail-row">
          <p><strong>Tanggal:</strong> {{ transaction.pembelian_tanggal }}</p>
        </div>
        <div class="transaction-detail-row">
          <p><strong>Pelanggan:</strong> {{ transaction.user.user_fullname }}</p>
        </div>
        <div class="transaction-detail-row">
          <p><strong>Username:</strong> {{ transaction.user.user_username }}</p>
        </div>
        <div class="transaction-detail-row">
          <p><strong>Metode Pembayaran:</strong> {{ transaction.metode_pembayaran.metode_pembayaran_jenis }}</p>
        </div>
        <div class="transaction-detail-row">
          <p><strong>Total Harga:</strong> Rp. {{ transaction.pembelian_total_harga.toLocaleString("id-ID") }}</p>
        </div>
        <div class="transaction-detail-row">
          <p><strong>Status:</strong> {{ transaction.status }}</p>
        </div>
        <div class="transaction-detail-row">
          <p><strong>Nomor Transaksi:</strong> {{ transaction.metode_pembayaran.metode_pembayaran_nomor ?? 'N/A' }}</p>
        </div>

        <h3>Detail Pembelian</h3>
        <ul>
          <li v-for="detail in transaction.detail_pembelian" :key="detail.pembelian_detail_id">
            <p><strong>Nama Pakaian:</strong> {{ detail.pakaian.pakaian_nama }}</p>
            <p><strong>Jumlah:</strong> {{ detail.pembelian_detail_jumlah }}</p>
            <p><strong>Total Harga:</strong> Rp. {{ detail.pembelian_detail_total_harga.toLocaleString("id-ID") }}</p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watch } from "vue";
import { getTransactionId } from "@/stores/transactionStore";

export default {
  name: "TransactionDetailModal",
  props: {
    isOpen: {
      type: Boolean,
      required: true,
    },
    transactionId: {
      type: Number,
      required: true,
    },
  },
  setup(props, { emit }) {
    const transaction = ref(null);

    const fetchTransactionDetails = async () => {
      try {
        const store = getTransactionId();
        const data = await store.authenticate(`user/pembelian/detail/${props.transactionId}`);
        console.log("Fetched transaction details:", data);
        transaction.value = data.data;
      } catch (error) {
        console.error("Failed to fetch transaction details:", error);
      }
    };

    const closeModal = () => {
      transaction.value = null;
      emit("close");
    };

    watch(() => props.isOpen, (newVal) => {
      if (newVal) {
        fetchTransactionDetails();
      }
    });

    return {
      transaction,
      closeModal,
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
  position: relative;
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  width: 80%;
  max-width: 600px;
}

.close-modal-button {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #333;
}

.close-modal-button:hover {
  color: #f44336;
}

.transaction-detail-row {
  margin-bottom: 10px; /* Adjust the value as needed */
}
</style>