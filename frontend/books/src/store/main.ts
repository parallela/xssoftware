import { createStore } from "vuex";
import { api } from "@/api";

export const store: any = createStore({
  state() {
    return {
      user: {},
      books: [],
      users: [],
      booksCollection: [],
    };
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user;
    },
    GET_USER(state) {
      if (Object.keys(state.user).length === 0) {
        api
          .get("/api/auth/user", {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("accessToken")}`,
            },
          })
          .then((response) => {
            state.user = response.data;
          })
          .catch((error) => {
            state.user = {};
          });
      }
    },
    SET_BOOKS(state, books) {
      state.books = books;
    },
    SET_USERS(state, users) {
      state.users = users;
    },
    SET_BOOKS_COLLECTION(state, booksCollection) {
      state.booksCollection = booksCollection;
    },
  },
  getters: {
    USER_IS_AUTHENTICATED(state) {
      return (
        Object.keys(state.user).length !== 0 ||
        localStorage.getItem("accessToken") !== null
      );
    },
    USER(state) {
      return state.user;
    },
    BOOKS(state) {
      return state.books;
    },
    BOOKS_COLLECTION(state) {
      return state.booksCollection;
    },
    USERS(state) {
      return state.users;
    },
  },
});
