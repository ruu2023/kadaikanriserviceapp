import { defineStore } from "pinia";
import { ref } from "vue";
import api from "../plugins/axios";

export const useAuthStore = defineStore("auth", () => {
    const user = ref(null);
    const token = ref(localStorage.getItem("token") || null);

    const fetchUser = async () => {
        console.log("start");
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
            user.value = null;
            token.value = null;
            localStorage.removeItem("token");
        }
    };

    return { user, token, fetchUser };
});
