import { defineStore } from "pinia";
import { ref } from "vue";
import { useRouter } from "vue-router";
import api, { setAuthToken } from "../plugins/axios";

export const useAuthStore = defineStore("auth", () => {
    const user = ref(null);
    const token = ref(localStorage.getItem("auth_token") || null);
    const router = useRouter();
    console.log("useAuthStore's token", token);
    // ユーザー情報を取得
    const fetchUser = async () => {
        if (!token.value) {
            user.value = null;
            return;
        }
        try {
            const response = await api.get("/user", {
                headers: { Authorization: `Bearer ${token.value}` },
                withCredentials: true,
            });
            user.value = response.data;
            console.log("response", response.data);
        } catch (error) {
            console.error("ユーザー情報の取得に失敗しました", error);
            logout(); // 失敗時はログアウト処理
        }
    };

    // ユーザー登録
    const register = async (registerData) => {
        try {
            const response = await api.post("/register", registerData, {
                withCredentials: true,
            });
            alert("登録成功: " + response.data.message);
            setAuthToken(response.data.token);
            await fetchUser();
            router.push("/dashboard");
        } catch (error) {
            console.error("登録エラー", error.response?.data);
            alert("登録エラー: " + JSON.stringify(error.response?.data));
        }
    };

    // ログイン
    const login = async (loginData) => {
        try {
            const response = await api.post("/login", loginData, {
                withCredentials: true,
            });
            alert("ログイン成功: " + response.data.message);
            setAuthToken(response.data.token);
            await fetchUser();
            router.push("/dashboard");
        } catch (error) {
            alert(
                "ログインエラー: " +
                    (error.response?.data?.message || "不明なエラー")
            );
        }
    };

    // ログアウト
    const logout = async () => {
        try {
            await api.post("/logout", {}, { withCredentials: true });
        } catch (error) {
            console.error("ログアウト失敗", error);
        } finally {
            token.value = null;
            user.value = null;
            localStorage.removeItem("token");
            router.push("/login");
        }
    };

    return { user, token, fetchUser, register, login, logout };
});
