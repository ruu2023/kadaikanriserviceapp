import axios from "axios";

const api = axios.create({
    baseURL: "http://localhost:8000/api",
    headers: {
        "Content-Type": "application/json",
    },
});

// 認証トークンをセットする関数
export function setAuthToken(token) {
    if (token) {
        api.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        localStorage.setItem("auth_token", token);
    } else {
        delete api.defaults.headers.common["Authorization"];
        localStorage.removeItem("auth_token");
    }
}

// ローカルストレージからトークンを復元
const token = localStorage.getItem("auth_token");
if (token) {
    setAuthToken(token);
}

export default api;
