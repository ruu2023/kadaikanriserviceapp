import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "./router"; // `resources/js/router/index.js`
import App from "./views/App.vue"; // `resources/js/views/App.vue`

const app = createApp(App);
app.use(router);
app.use(createPinia());
app.mount("#app");
