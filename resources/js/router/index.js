import { createWebHistory, createRouter } from "vue-router";
import routes from './routes';
import { useAuthStore } from '@/store/store';

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from) => {
    const { user, getUser } = useAuthStore();
    if (to.name !== 'Login' && !user) {
        try {
            await getUser();
        } catch {
            return { name: 'Login' };
        }
    }
});

export default router;
