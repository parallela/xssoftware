<script>
import {api} from "@/api";

export default {
  data() {
    return {};
  },
  mounted() {
    this.getBooks();
    this.$store.commit('GET_USER');
  },
  computed: {
    books() {
      return this.$store.getters.BOOKS_COLLECTION;
    },
  },
  methods: {
    getBooks() {
      api.get('/api/books/collect', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('accessToken')}`
        }
      }).then((response) => {
        this.$store.commit('SET_BOOKS_COLLECTION', response.data)
      }).catch((error) => {
        this.$store.commit('SET_BOOKS_COLLECTION', []);
      })
    },
    removeBook(bookId) {
      api.delete(`/api/books/collect?id=${bookId}`,{
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('accessToken')}` // We can move that into global constant but for the task i'll use is directly from storage
        }
      }).then((response) => {
        this.$store.commit('SET_BOOKS_COLLECTION', this.$store.getters.BOOKS_COLLECTION.filter((item) => item.id !== bookId))
      }).catch((error) => {
      })
    }
  }
}
</script>

<template>
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10 mr-10 ml-10">
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
          <button v-on:click="removeBook(book.id)" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-200 to-red-600 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
              <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Remove
                </span>
          </button>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>