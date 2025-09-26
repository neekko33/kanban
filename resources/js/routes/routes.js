import { createMemoryHistory, createRouter } from "vue-router";

export const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../pages/Login.vue')
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        meta: {
            isMenu: true,
            icon: 'heroicons:home',
        },
        component: () => import('../pages/Dashboard.vue')
    },
    {
        path: '/kanban',
        name: 'Kanban',
        meta: {
            isMenu: true,
            group: 'Task',
            icon: 'heroicons:view-columns'
        },
        component: () => import('../pages/Kanban.vue')
    },
    {
        path: '/history',
        name: 'History',
        meta: {
            isMenu: true,
            group: 'Task',
            icon: 'heroicons:clock'
        },
        component: () => import('../pages/HistoryTasks.vue')
    },
];

const router = createRouter({
    history: createMemoryHistory(),
    routes,
});

export default router;
