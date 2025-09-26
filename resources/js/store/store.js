import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from '@/apis'

export const useAuthStore = defineStore('auth', () => {
    const user = ref(null);

    const login = async (userInfo) => {
        // initialize CSRF
        await axios.get('/sanctum/csrf-cookie');
        const { data } = await axios.post('/login', userInfo);
        user.value = data.user;
    }

    const logout = () => {
        user.value = null;
    }

    return { user, login, logout };
})

