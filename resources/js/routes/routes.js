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
        component: () => import('../pages/task/Kanban.vue')
    },
    {
        path: '/history',
        name: 'History',
        meta: {
            isMenu: true,
            group: 'Task',
            icon: 'heroicons:clock'
        },
        component: () => import('../pages/task/History.vue')
    },
    {
        path: '/post',
        name: 'Post',
        meta: {
            isMenu: true,
            group: 'Blog',
            icon: 'heroicons:book-open'
        },
        component: () => import('../pages/blog/Post.vue')
    },
    {
        path: '/category',
        name: 'Category',
        meta: {
            isMenu: true,
            group: 'Blog',
            icon: 'heroicons:inbox-stack'
        },
        component: () => import('../pages/blog/Category.vue')
    },
    {
        path: '/tag',
        name: 'Tag',
        meta: {
            isMenu: true,
            group: 'Blog',
            icon: 'heroicons:tag'
        },
        component: () => import('../pages/blog/Tag.vue')
    },
];

const router = createRouter({
    history: createMemoryHistory(),
    routes,
});

export default router;
