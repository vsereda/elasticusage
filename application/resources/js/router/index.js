import {createRouter, createWebHistory} from "vue-router";

import Home from "../pages/Home.vue";
import Article from "../pages/Article.vue";

const routes = [
    {
        path: '/',
        component: Home,
        name: 'home'
    },
    {
        path: '/article/:id',
        component: Article,
        name: 'article',
    },
];

const router = createRouter({
    routes,
    history: createWebHistory()
});

export default router;
