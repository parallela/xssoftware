<script>
import {api} from "@/api";

export default {
  data() {
    return {
      collected: false,
    }
  },
  mounted() {
    this.getUsersForApprove();
    // this.$store.commit('GET_USER');
  },
  computed: {
    users() {
      return this.$store.getters.USERS;
    },
  },
  methods: {
    getUsersForApprove() {
      api.get('/api/users', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('accessToken')}`
        }
      }).then((response) => {
        this.$store.commit('SET_USERS', response.data)
      }).catch((error) => {
        this.$store.commit('SET_USERS', []);
      })
    },
    approve(userId) {
      api.put(`/api/users?id=${userId}`, null, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('accessToken')}` // We can move that into global constant but for the task i'll use is directly from storage
        }
      }).then((response) => {
        this.$store.commit('SET_USERS', this.users.filter((item) => item.id != userId));
      }).catch((error) => {
      })
    }
  }
}
</script>

<template>
  <main class="grid place-items-center mb-5">
    <h4 class="mt-5">Approve users</h4>
    <div class="md-5 ml-5 mr-5 mt-5 bg-gray-900 rounded w-2/3">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th class="px-6 py-3" scope="col">
            Name
          </th>
          <th class="px-6 py-3" scope="col">
            Action
          </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="user in users" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
          <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" scope="row">
            {{ user.name }}
          </th>
          <td class="px-6 py-4">
            <button :disabled="this.collected"
                    class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-100 to-blue-600 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800"
                    v-on:click="approve(user.id)">
              <span
                  class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Approve
                </span>
            </button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </main>
</template>
