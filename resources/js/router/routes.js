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
            // {
            //     path: '/history',
            //     name: 'History',
            //     meta: {
            //         isMenu: true,
            //         group: 'Task',
            //         icon: 'heroicons:clock'
            //     },
            //     component: () => import('../pages/task/History.vue')
            // },
            {
                path: "/post",
                name: "Post",
                meta: {
                    isMenu: true,
                    group: "Blog",
                    icon: "heroicons:book-open",
                },
                redirect: { name: "PostList" },
                component: () => import("../pages/blog/Post.vue"),
                children: [
                    {
                        path: "",
                        name: "PostList",
                        component: () => import("../pages/blog/PostList.vue"),
                    },
                    {
                        path: "create",
                        name: "PostCreate",
                        component: () => import("../pages/blog/PostEdit.vue"),
                    },
                    {
                        path: "edit/:id",
                        name: "PostEdit",
                        component: () => import("../pages/blog/PostEdit.vue"),
                    },
                ],
            },
            {
                path: "/category",
                name: "Category",
                meta: {
                    isMenu: true,
                    group: "Blog",
                    icon: "heroicons:inbox-stack",
                },
                component: () => import("../pages/blog/Category.vue"),
            },
            {
                path: "/tag",
                name: "Tag",
                meta: {
                    isMenu: true,
                    group: "Blog",
                    icon: "heroicons:tag",
                },
                component: () => import("../pages/blog/Tag.vue"),
            },
        ],
    },
];

export default routes;
