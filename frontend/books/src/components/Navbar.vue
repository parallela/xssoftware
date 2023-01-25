<script>
import {api} from "@/api";

export default {
    computed: {
      userIsAuthenticated() {
        return this.$store.getters.USER_IS_AUTHENTICATED;
      }
    },
    methods: {
      logout() {
        // we can move this headers and miscs into global config too.
        api.get('/api/auth/logout', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('accessToken')}` // We can move that into global constant but for the task i'll use is directly from storage
          }
        })
            .then((result) => {
              this.$store.commit('SET_USER', {});
              localStorage.removeItem('accessToken');
            })
            .catch((error) => {});
      }
    }
  }
</script>
<template>
  <nav class="bg-gray-50 dark:bg-gray-700">
    <div class="max-w-screen-xl px-4 py-3 mx-auto md:px-6">
      <div class="flex items-center">
        <ul class="flex flex-row mt-0 mr-6 space-x-8 text-sm font-medium">
          <li>
            <router-link to="/" class="text-gray-900 dark:text-white hover:underline" aria-current="page">Home</router-link>
          </li>
          <li v-if="!this.userIsAuthenticated" >
            <router-link to="/login" class="text-gray-900 dark:text-white hover:underline" aria-current="page">Login</router-link>
          </li>
          <li v-if="!this.userIsAuthenticated" i>
            <router-link to="/register" class="text-gray-900 dark:text-white hover:underline" aria-current="page">Register</router-link>
          </li>
          <li v-if="this.userIsAuthenticated">
            <router-link to="/books" class="text-gray-900 dark:text-white hover:underline">My Books</router-link>
          </li>
          <li v-if="this.userIsAuthenticated">
            <router-link to="/account" class="text-gray-900 dark:text-white hover:underline">Account</router-link>
          </li>
          <li v-if="this.userIsAuthenticated">
            <a v-on:click="logout" class="text-gray-900 dark:text-white hover:underline">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>