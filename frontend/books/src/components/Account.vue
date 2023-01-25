<script>
import {api} from '@/api';
import EditUserForm from "@/components/EditUserForm.vue";
import AdminApproveTable from "@/components/AdminApproveTable.vue";
export default {
  components: {EditUserForm, AdminApproveTable},
  mounted() {
    this.$store.commit('GET_USER');
  },
  data() {
    return {}
  },
  computed: {
    user() {
      return this.$store.getters.USER;
    }
  }
}
</script>

<template>
  <EditUserForm :user="this.user" />
  <AdminApproveTable v-if="this.user.admin == 1"/>
</template>