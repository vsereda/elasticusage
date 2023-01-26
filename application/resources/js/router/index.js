import {createRouter, createWebHistory} from "vue-router";

import Home from "../pages/Home.vue";
import About from "../pages/About.vue";

const routes = [
    {
        path: '/',
        component: Home,
        name: 'home'
    },
    {
        path: '/about',
        component: About,
        name: 'about',
    },
];

const router = createRouter({
    routes,
    history: createWebHistory()
});

export default router;
