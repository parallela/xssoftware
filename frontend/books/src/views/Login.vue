<script>
import {api} from '@/api'

export default {
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      error: ''
    }
  },
  mounted() {
  },
  methods: {
    login() {
      api.post('/api/auth/login', this.$data.form)
          .then((result) => {
            localStorage.setItem('accessToken', result.data.access_token);
            this.$store.commit('SET_USER', result.data.user.user);
            this.error = '';
          })
          .catch((error) => {
            this.$store.commit('SET_USER', {});
            localStorage.removeItem('accessToken');
            this.$data.error = error.response.data.error;
          });
    }
  }
}
</script>

<template>
  <main class="grid place-items-center">
    <div class="md-5 ml-5 mr-5 mt-5 bg-gray-900 rounded w-2/3" v-if="!this.$store.getters.USER_IS_AUTHENTICATED">
      <div class="pd-5 pl-5 pr-5 pt-10">
        <label class="block mb-2 text-sm font-medium text-gray-100" for="helper-text">Your email</label>
        <input id="helper-text" v-model="form.email" aria-describedby="helper-text-explanation"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="name@example.com"
               type="email">
      </div>
      <div class="md-5 ml-5 mr-5 mt-5">
        <label class="block mb-2 text-sm font-medium text-gray-100" for="helper-text2">Password</label>
        <input id="helper-text2" v-model="form.password" aria-describedby="helper-text-explanation"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="Password"
               type="password">
      </div>
      <div v-if="error.length !== 0" class="md-5 ml-5 mr-5 mt-5">
        <p class="text-red-300">{{ error }}</p>
      </div>
      <div class="md-5 ml-5 mr-5 mt-5">
        <button
            class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800"
            v-on:click="login">
      <span
          class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
        Login
      </span>
        </button>
      </div>
    </div>
    <div class="md-5 ml-5 mr-5 mt-5 bg-gray-900 rounded w-2/3" v-if="this.$store.getters.USER_IS_AUTHENTICATED">
      <div class="pd-5 pl-5 pr-5 pt-2 text-gray-100 mb-2">
        <h5>You are logged in successfully!</h5>
      </div>
    </div>
  </main>
</template>