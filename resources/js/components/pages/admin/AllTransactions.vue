<template>
  <Sidebar />
  <div :class="['wrapper', { 'wrapper-mobile': isMobile }]">
    <div class="header-container">
      <div class="title-container">
        <h1>All Transactions</h1>
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
          <tr v-for="transaction in transactions" :key="transaction.pembelian_id">
            <td>{{ transaction.pembelian_tanggal }}</td>
            <td>{{ transaction.user.user_fullname }}</td>
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
    <TransactionDetailModal :isOpen="isModalOpen" :transactionId="selectedTransactionId" @close="closeModal" />
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useTransactionStore } from "@/stores/transactionStore";
import Sidebar from "../../Sidebar.vue";
import TransactionDetailModal from "../../TransactionDetailModal.vue";

export default {
  name: "AllTransactions",
  components: {
    Sidebar,
    TransactionDetailModal,
  },
  setup() {
    const transactions = ref([]);
    const isModalOpen = ref(false);
    const selectedTransactionId = ref(null);
    const isMobile = ref(window.innerWidth <= 768);

    const fetchTransactions = async () => {
      try {
        const store = useTransactionStore();
        const data = await store.getAllTransactions();
        transactions.value = data;
      } catch (error) {
        console.error("Failed to fetch transactions:", error);
      }
    };

    const openModal = (transactionId) => {
      selectedTransactionId.value = transactionId;
      isModalOpen.value = true;
    };

    const closeModal = () => {
      isModalOpen.value = false;
      selectedTransactionId.value = null;
    };

    onMounted(() => {
      fetchTransactions();
      window.addEventListener('resize', () => {
        isMobile.value = window.innerWidth <= 768;
      });
    });

    return {
      transactions,
      isModalOpen,
      selectedTransactionId,
      openModal,
      closeModal,
      isMobile,
    };
  },
};
</script>

<style scoped>
.wrapper {
  padding: 1rem;
  margin-left: 250px; /* Adjust for sidebar width */
}

.wrapper-mobile {
  margin-left: 0;
  padding-top: 4rem; /* Add padding for mobile view to avoid overlap */
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