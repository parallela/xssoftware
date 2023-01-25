<script>
import {api} from "@/api";

export default {
  props: ['user'],
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
    if (this.user.id) {
      this.setUserForm(this.user);
    }
  },
  watch: {
    user() {
      this.setUserForm(this.user);
    }
  },
  methods: {
    setUserForm(user) {
      this.form = {
        first_name: user.name.split(' ')[0],
        last_name: user.name.split(' ')[1],
        email: user.email,
        password: ''
      }
    },
    update() {
      api.put('/api/auth/user', this.$data.form, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('accessToken')}`
        }
      })
          .then((result) => {
            this.error = '';
            this.$store.commit('SET_USER', result.data);
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
        <label class="block mb-2 text-sm font-medium text-gray-100" for="helper-text">Your email</label>
        <input id="helper-text" v-model="this.form.email" aria-describedby="helper-text-explanation"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="name@example.com"
               type="email">
      </div>
      <div class="md-5 ml-5 mr-5 mt-5">
        <label class="block mb-2 text-sm font-medium text-gray-100" for="helper-text3">First Name</label>
        <input id="helper-text3" v-model="this.form.first_name" aria-describedby="helper-text-explanation"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="First Name"
               type="text">
      </div>
      <div class="md-5 ml-5 mr-5 mt-5">
        <label class="block mb-2 text-sm font-medium text-gray-100" for="helper-text4">Last Name</label>
        <input id="helper-text4" v-model="this.form.last_name" aria-describedby="helper-text-explanation"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="Last Name"
               type="text">
      </div>
      <div class="md-5 ml-5 mr-5 mt-5">
        <label class="block mb-2 text-sm font-medium text-gray-100" for="helper-text5">Password</label>
        <input id="helper-text5" v-model="this.form.password" aria-describedby="helper-text-explanation"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="Password"
               type="password">
      </div>
      <div class="md-5 ml-5 mr-5 mt-5">
        <button
            class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800"
            v-on:click="update">
          <span
              class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
             Update
          </span>
        </button>
      </div>

    </div>
    <div v-if="this.success" class="md-5 ml-5 mr-5 mt-5 bg-gray-900 rounded w-2/3">
      <div class="pd-5 pl-5 pr-5 pt-2 text-gray-100 mb-2">
        <h5>You are register successfully!</h5>
      </div>
    </div>
  </main>
</template>