<script>
import {api} from '@/api'

export default {
  data() {
    return {
      form: {
        name: '',
        isbn: ''
      },
      error: '',
      success: false
    }
  },
  mounted() {
    if(this.$store.getters.USER.admin != 1) {
      window.location.href = '/';
    }
  },
  methods: {
    create() {
      api.post('/api/books', this.$data.form, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('accessToken')}`
          }
      })
          .then((result) => {
            this.success = true;
            this.error = '';
          })
          .catch((error) => {
            this.success = false;
            this.$data.error = error.response.data.error;
          });
    }
  }
}
</script>

<template>
  <main class="grid place-items-center">
    <div class="md-5 ml-5 mr-5 mt-5 bg-gray-900 rounded w-2/3" v-if="this.$store.getters.USER.admin == 1">
      <div class="pd-5 pl-5 pr-5 pt-10">
        <label class="block mb-2 text-sm font-medium text-gray-100" for="helper-text">Name</label>
        <input id="helper-text" v-model="form.name" aria-describedby="helper-text-explanation"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="Dancho e qk"
               type="text">
      </div>
      <div class="md-5 ml-5 mr-5 mt-5">
        <label class="block mb-2 text-sm font-medium text-gray-100" for="helper-text2">ISBN</label>
        <input id="helper-text2" v-model="form.isbn" aria-describedby="helper-text-explanation"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="123-456-789"
               type="text">
      </div>
      <div v-if="error.length !== 0" class="md-5 ml-5 mr-5 mt-5">
        <p class="text-red-300">{{ error }}</p>
      </div>
      <div class="md-5 ml-5 mr-5 mt-5">
        <button
            class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800"
            v-on:click="create">
      <span
          class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
       Create
      </span>
        </button>
      </div>
    </div>
    <div class="md-5 ml-5 mr-5 mt-5 bg-gray-900 rounded w-2/3" v-if="success">
      <div class="pd-5 pl-5 pr-5 pt-2 text-gray-100 mb-2">
        <h5>The book is created successfully!</h5>
      </div>
    </div>
  </main>
</template>