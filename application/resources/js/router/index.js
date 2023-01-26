import {createRouter, createWebHistory} from "vue-router";

import Home from "../pages/Home.vue";
import Article from "../pages/Article.vue";
import ArticleSearch from "../components/ArticleSearch.vue";

const routes = [
    {
        path: '/',
        component: Home,
        name: 'home'
    },
    {
        path: '/articles/create',
        component: Article,
        name: 'article',
    },
    {
        path: '/articles/:id',
        component: Article,
        name: 'article',
    },
    {
        path: '/articles/search',
        component: ArticleSearch,
        name: 'article.search',
    },
];

const router = createRouter({
    routes,
    history: createWebHistory()
});

export default router;
