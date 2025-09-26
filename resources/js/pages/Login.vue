<script setup>
import { reactive } from 'vue';
import { useAuthStore } from '@/store/store';
import { useRouter } from 'vue-router';

const { login } = useAuthStore();
const router = useRouter();

const userInfo = reactive({
    email: '',
    password: ''
});

const handleLogin = async () => {
    await login(userInfo);
    router.push('/');
};

</script>

<template>
    <div class="bg-base-200 h-screen w-screen pt-42">
        <div class="card bg-base-100 w-lg shadow-sm mx-auto">
            <div class="card-body">
                <h2 class="card-title text-2xl">Kanban Admin</h2>
                <form class="my-6 ">
                    <div class="mb-4 flex flex-col items-center justify-center">
                        <label class="input validator">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                    stroke="currentColor">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </g>
                            </svg>
                            <input v-model="userInfo.email" type="email" placeholder="mail@site.com" required />
                        </label>
                        <div class="validator-hint hidden">Enter valid email address</div>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <label class="input validator">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                    stroke="currentColor">
                                    <path
                                        d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z">
                                    </path>
                                    <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                </g>
                            </svg>
                            <input v-model="userInfo.password" type="password" required placeholder="Password" />
                        </label>
                        <p class="validator-hint hidden">
                            Enter valid password
                        </p>
                    </div>
                </form>
                <div class="card-actions justify-end">
                    <button class="btn btn-primary" @click="handleLogin">Log in</button>
                </div>
            </div>
        </div>
    </div>

</template>
