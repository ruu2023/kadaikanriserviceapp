import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "./router"; // `resources/js/router/index.js`
import App from "./App.vue"; // `resources/js/App.vue`

const app = createApp(App);
app.use(router);
app.use(createPinia());
app.mount("#app");
