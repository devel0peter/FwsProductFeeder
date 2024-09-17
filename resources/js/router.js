import { createRouter, createWebHistory } from "vue-router";

import Home from './pages/Home.vue';
import ImportProducts from './pages/ImportProducts.vue';

// Define routes
const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/import-products',
        name: 'ImportProducts',
        component: ImportProducts,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
