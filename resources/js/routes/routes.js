import { createMemoryHistory, createRouter } from "vue-router";

const routes = [
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
        name: 'dashboard',
        component: () => import('../pages/Dashboard.vue')
    },
    {
        path: '/kanban',
        name: 'kanban',
        component: () => import('../pages/Kanban.vue')
    },
    {
        path: '/history',
        name: 'history',
        component: () => import('../pages/HistoryTasks.vue')
    },
    // {
    //     path: '/settings',
    //     name: 'settings',
    //     component: () => import('../pages/Settings.vue')
    // }
];

const router = createRouter({
    history: createMemoryHistory(),
    routes,
});

export default router;
