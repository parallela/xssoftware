<script>
import {api} from "@/api";

export default {
  data() {
    return {
      collected: false,
    }
  },
  mounted() {
    this.getBooks();
    this.$store.commit('GET_USER');
  },
  computed: {
    books() {
      return this.$store.getters.BOOKS;
    },
    user() {
      return this.$store.getters.USER;
    }
  },
  methods: {
    getBooks() {
      api.get('/api/books', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('accessToken')}`
        }
      }).then((response) => {
        this.$store.commit('SET_BOOKS', response.data)
      }).catch((error) => {
        this.$store.commit('SET_BOOKS', []);
      })
    },
    collectBook(bookId) {
      api.post(`/api/books/collect?id=${bookId}`,null, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('accessToken')}` // We can move that into global constant but for the task i'll use is directly from storage
        }
      }).then((response) => {
        this.$data.collected = true;

        // Remove the button collected state
        setTimeout(() => {
          this.$data.collected = false;
        },2000);
      }).catch((error) => {
        this.$data.collected = false;
      })
    }
  }
}
</script>

<template>
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10 mr-10 ml-10">

    <router-link to="/books/create" v-if="user.admin == 1" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-600 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800" :disabled="this.collected">
              <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Create a book
                </span>
    </router-link>


    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
      <tr>
        <th scope="col" class="px-6 py-3">
          Book Name
        </th>
        <th scope="col" class="px-6 py-3">
          ISBN
        </th>
        <th scope="col" class="px-6 py-3">
          Action
        </th>
      </tr>
      </thead>
      <tbody>
      <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700" v-for="book in books">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
          {{book.name}}
        </th>
        <td class="px-6 py-4">
          {{book.isbn}}
        </td>
        <td class="px-6 py-4">
          <router-link :to="`/books/update?id=${book.id}`" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
              <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Edit
                </span>
          </router-link>

          <button v-on:click="collectBook(book.id)" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-100 to-blue-600 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800" :disabled="this.collected">
              <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                {{collected ? 'Collected' : 'Add To Favorites'}}
                </span>
          </button>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>