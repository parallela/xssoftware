import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
// @ts-ignore
import { store } from "./store/main.ts";
import axios from "axios";

import "./assets/main.css";

const app = createApp(App);

app.use(router);
app.use(store);

app.mount("#app");
