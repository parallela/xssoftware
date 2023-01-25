import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/login",
      name: "login",
      component: () => import("../views/Login.vue"),
    },
    {
      path: "/register",
      name: "register",
      component: () => import("../views/Register.vue"),
    },
    {
      path: "/account",
      name: "account",
      component: () => import("../views/Account.vue"),
    },
    {
      path: "/books",
      name: "my-books",
      component: () => import("../views/MyBooks.vue"),
    },
    {
      path: "/books/create",
      name: "books-create",
      component: () => import("../views/CreateBook.vue"),
    },
    {
      path: "/books/update",
      name: "books-create",
      component: () => import("../views/EditBook.vue"),
    },
    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import('../views/AboutView.vue')
    // }
  ],
});

export default router;
