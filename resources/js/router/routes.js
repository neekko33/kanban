const routes = [
    {
        path: "/login",
        name: "Login",
        component: () => import("../pages/Login.vue"),
    },
    {
        path: "/",
        name: "Home",
        component: () => import("../pages/Home.vue"),
        children: [
            {
                path: "",
                name: "Root",
                redirect: "/dashboard",
            },
            {
                path: "/dashboard",
                name: "Dashboard",
                meta: {
                    isMenu: true,
                    icon: "heroicons:home",
                },
                component: () => import("../pages/Dashboard.vue"),
            },
            {
                path: "/kanban",
                name: "Kanban",
                meta: {
                    isMenu: true,
                    group: "Task",
                    icon: "heroicons:view-columns",
                },
                component: () => import("../pages/task/Kanban.vue"),
            },
            {
                path: "/settings",
                name: "Settings",
                component: () => import("../pages/Settings.vue"),
            }
        ],
    },
];

export default routes;
