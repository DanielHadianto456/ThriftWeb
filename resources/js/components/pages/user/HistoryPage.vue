<template>
  <Header />
  <div class="wrapper">
    <div class="table-card">
      <div class="header-container">
        <div class="title-container">
          <h1>History</h1>
          <h2>Your Orders History</h2>
        </div>
      </div>
      <div class="table-container">
        <table class="table-list">
          <thead>
            <tr>
              <td>Tanggal</td>
              <td>Pelanggan</td>
              <td>Metode Pembayaran</td>
              <td>Total Harga</td>
              <td>Status Transaksi</td>
              <td>Actions</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="transaction in filteredTransactions" :key="transaction.pembelian_id">
              <td>{{ transaction.pembelian_tanggal }}</td>
              <td>{{ transaction.user.user_username }}</td>
              <td>{{ transaction.metode_pembayaran.metode_pembayaran_jenis }}</td>
              <td>Rp. {{ transaction.pembelian_total_harga.toLocaleString("id-ID") }}</td>
              <td :style="{ color: transaction.status === 'BELUM_LUNAS' ? '#BE0000' : 'green', fontWeight: 'bold' }">
                {{ transaction.status }}
              </td>
              <td>
                <button @click="openModal(transaction.pembelian_id)">View Details</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <TransactionDetailModal :isOpen="isModalOpen" :transactionId="selectedTransactionId" @close="closeModal" />
  </div>
</template>

<script>
import { computed, ref } from "vue";
import { getAllTransaction } from "@/stores/transactionStore";
import { useUserStore } from "@/stores/userStore";
import Header from "../../Header.vue";
import TransactionDetailModal from "../../TransactionDetailModal.vue";

export default {
  name: "HistoryPage",
  components: {
    Header,
    TransactionDetailModal,
  },
  data() {
    return {
      transactions: [],
      isModalOpen: false,
      selectedTransactionId: null,
    };
  },
  computed: {
    filteredTransactions() {
      const userStore = useUserStore();
      return this.transactions.filter(transaction => transaction.user_id === userStore.user_id);
    },
  },
  methods: {
    async fetchTransactions() {
      try {
        const store = getAllTransaction();
        const data = await store.authenticate("user/pembelian");
        console.log("Fetched data:", data);
        this.transactions = data.data;
      } catch (error) {
        console.error("Failed to fetch transactions:", error);
      }
    },
    openModal(transactionId) {
      this.selectedTransactionId = transactionId;
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
      this.selectedTransactionId = null;
    },
  },
  mounted() {
    const userStore = useUserStore();
    console.log("Decoded token contents in mounted:", {
      user_id: userStore.user_id,
      role: userStore.role,
      username: userStore.username,
    });
    this.fetchTransactions();
  },
};
</script>

<style scoped>
.wrapper {
  padding: 1rem;
}

.table-card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 1rem;
}

.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.title-container h1 {
  margin: 0;
}

.table-container {
  overflow-x: auto;
}

.table-list {
  width: 100%;
  border-collapse: collapse;
}

.table-list th,
.table-list td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.table-list th {
  background-color: #f9f9f9;
  font-weight: bold;
}

.table-list tr:hover {
  background-color: #f1f1f1;
}

.table-list td {
  color: black;
}
</style>