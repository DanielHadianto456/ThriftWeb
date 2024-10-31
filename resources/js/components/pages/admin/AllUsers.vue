<template>
  <Sidebar />
  <div :class="['wrapper', { 'wrapper-mobile': isMobile }]">
    <div class="header-container">
      <div class="title-container">
        <h1>All Users</h1>
      </div>
    </div>
    <div class="table-container">
      <table class="table-list">
        <thead>
          <tr>
            <!-- <td>ID</td> -->
            <td>Username</td>
            <td>Full Name</td>
            <td>Email</td>
            <td>Alamat</td>
            <td>Nomor Handphone</td>
            <td>Role</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.user_id">
            <!-- <td>{{ user.user_id }}</td> -->
            <td>{{ user.user_username }}</td>
            <td>{{ user.user_fullname }}</td>
            <td>{{ user.user_email }}</td>
            <td>{{ user.user_alamat }}</td>
            <td>{{ user.user_nohp }}</td>
            <td>{{ user.user_level }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useAdminStore } from "@/stores/adminStore";
import Sidebar from "../../Sidebar.vue";

export default {
  name: "AllUsers",
  components: {
    Sidebar,
  },
  setup() {
    const users = ref([]);
    const isMobile = ref(window.innerWidth <= 768);

    const fetchUsers = async () => {
      try {
        const store = useAdminStore();
        const data = await store.getAllUsers();
        users.value = data;
      } catch (error) {
        console.error("Failed to fetch users:", error);
      }
    };

    onMounted(() => {
      fetchUsers();
      window.addEventListener('resize', () => {
        isMobile.value = window.innerWidth <= 768;
      });
    });

    return {
      users,
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