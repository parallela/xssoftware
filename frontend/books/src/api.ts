import axios from "axios";
import { store } from "@/store/main";

const api = axios.create({
  baseURL: "http://xssoftware.test/",
  timeout: 1000,
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});

// Handle authentication redirect when the status is 401 unauthroized
api.interceptors.response.use(undefined, function (error) {
  if (error.response.status === 401) {
    store.commit("SET_USER", {});
    localStorage.removeItem("accessToken");

    window.location.href = "/login";

    return;
  }

  return Promise.reject(error);
});

export { api };
