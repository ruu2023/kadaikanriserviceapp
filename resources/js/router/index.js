import { createRouter, createWebHistory } from "vue-router";
import AuthView from "../views/Auth.vue"; // `@/` が使えない場合に備えて相対パス
import DashboardView from "../layouts/Dashboard.vue";

const routes = [
    { path: "/login", name: "login", component: AuthView },
    {
        path: "/dashboard",
        name: "dashboard",
        component: DashboardView,
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// computedを使ってローカルストレージからtokenを取得: 直接取得するとnullになる
import { computed } from "vue";
const isAuthenticated = computed(() => !!localStorage.getItem("token"));

// ナビゲーションガード（ログインしていない場合はリダイレクト）
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !isAuthenticated) {
        next({ name: "login" });
    } else {
        next();
    }
});

export default router;
