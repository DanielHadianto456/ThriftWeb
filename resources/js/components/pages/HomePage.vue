<template>
  <Header />
  <div>
    HOMEEEEE hello BOYS
    <nav>
      <div>
        <router-link :to="{ name: 'CheckClothing' }">Hey hey</router-link>
        <router-link to="/admin/AddClothing"> WHT</router-link>
      </div>
      <div>
        WAHTTTT
        <h1>User Role: {{ role }}</h1>
        <h1>Username: {{ username }}</h1>
      </div>
    </nav>
  </div>
</template>

<script>
import { useUserStore } from "@/stores/userStore";
import Header from "../Header.vue";

export default {
  name: "HomePage",
  components: {
    Header,
  },
  data() {
    return {
      role: null,
      username: null,
    };
  },
  methods: {
    fetchUserData() {
      try {
        const store = useUserStore();
        this.role = store.role;
        this.username = store.username;
      } catch (error) {
        console.error("Failed to fetch user data:", error);
      }
    },
  },
  mounted() {
    this.fetchUserData();
  },
};
</script>