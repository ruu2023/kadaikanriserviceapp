import { createRouter, createWebHistory } from "vue-router";
import AuthView from "../pages/Auth.vue"; // `@/` が使えない場合に備えて相対パス
import DashboardView from "../pages/Dashboard.vue";
import { useAuthStore } from "../stores/authStore"; // Pinia のストアをインポート
import { storeToRefs } from "pinia";

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

// ナビゲーションガード（ログインしていない場合はリダイレクト）
router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();
    const { user, token } = storeToRefs(authStore);
    if (to.meta.requiresAuth) {
        if (!user.value && token.value) {
            await authStore.fetchUser();
        }
        if (!user.value) {
            next({ name: "login" });
            return;
        }
    }
    next();
});

export default router;
