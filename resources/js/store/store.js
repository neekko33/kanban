import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from '@/apis'
import { useRouter } from 'vue-router';

export const useAuthStore = defineStore('auth', () => {
    const user = ref(null);
    const router = useRouter();

    const login = async (userInfo) => {
        // initialize CSRF
        await axios.get('/sanctum/csrf-cookie');
        const { data } = await axios.post('/login', userInfo);
        user.value = data.user;
    }

    const logout = () => {
        user.value = null;
        router.push({ name: "Login" });
    }

    const getUser = async () => {
        const { data } = await axios.get('/me');
        user.value = data.user;
    }

    return { user, login, logout, getUser };
})

