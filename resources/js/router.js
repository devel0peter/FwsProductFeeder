import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/home",
        name: "home",
        component: () => import("./pages/Home.vue"),
    },
    {
        path: "/test",
        name: "test",
        component: () => import("./pages/Test.vue"),
    }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
