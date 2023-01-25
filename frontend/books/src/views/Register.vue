<script>
import {api} from '@/api'

export default {
  data() {
    return {
      form: {
        first_name: '',
        last_name: '',
        email: '',
        password: ''
      },
      error: '',
      success: false,
    }
  },
  mounted() {
  },
  methods: {
    register() {
      api.post('/api/auth/register', this.$data.form)
          .then((result) => {
            this.error = '';
          })
          .catch((error) => {
            this.$data.error = error.response.data.error;
          });
    }
  }
}
</script>
<template>
  <main class="grid place-items-center">
    <div class="md-5 ml-5 mr-5 mt-5 bg-gray-900 rounded w-2/3">
      <div class="pd-5 pl-5 pr-5 pt-10">
        <label for="helper-text" class="block mb-2 text-sm font-medium text-gray-100">Your email</label>
        <input type="email" v-model="this.form.email" id="helper-text" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@example.com">
      </div>
      <div class="md-5 ml-5 mr-5 mt-5">
        <label for="helper-text3" class="block mb-2 text-sm font-medium text-gray-100">First Name</label>
        <input type="text"  v-model="this.form.first_name" id="helper-text3" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="First Name">
      </div>
      <div class="md-5 ml-5 mr-5 mt-5">
        <label for="helper-text4"  class="block mb-2 text-sm font-medium text-gray-100">Last Name</label>
        <input type="text" v-model="this.form.last_name"  id="helper-text4" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Last Name">
      </div>
      <div class="md-5 ml-5 mr-5 mt-5">
        <label for="helper-text5" class="block mb-2 text-sm font-medium text-gray-100">Password</label>
        <input type="password" v-model="this.form.password"  id="helper-text5" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Password">
      </div>
      <div class="md-5 ml-5 mr-5 mt-5">
        <button v-on:click="register" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
          <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
              Register
          </span>
        </button>
      </div>

    </div>
    <div class="md-5 ml-5 mr-5 mt-5 bg-gray-900 rounded w-2/3" v-if="this.success">
      <div class="pd-5 pl-5 pr-5 pt-2 text-gray-100 mb-2">
        <h5>You are register successfully!</h5>
      </div>
    </div>
  </main>
</template>
