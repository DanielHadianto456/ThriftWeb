<template>
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
      </div>
    </nav>
  </div>
</template>

<script>
import { useUserStore } from "@/stores/userStore";

export default {
  name: "HomePage",
  data() {
    return {
      role: null,
    };
  },
  methods: {
    fetchRole() {
      try {
        const store = useUserStore();
        this.role = store.role;
      } catch (error) {
        console.error("Failed to fetch role:", error);
      }
    },
  },
  mounted() {
    this.fetchRole();
  },
};
</script>