import {createRouter, createWebHistory} from "vue-router";

import Home from "../pages/Home.vue";
import NewArticle from "../pages/NewArticle.vue";
import ArticleSearch from "../pages/ArticleSearch.vue";
import PageNotFound from "../pages/PageNotFound.vue";

const routes = [
    {
        path: '/',
        component: Home,
        name: 'home'
    },
    {
        path: '/articles/create',
        component: NewArticle,
        name: 'article.create',
    },
    {
        path: '/articles/search',
        component: ArticleSearch,
        name: 'article.search',
    },
    {
        path: '/:pathMatch(.*)*',
        component: PageNotFound,
    },
];

const router = createRouter({
    routes,
    history: createWebHistory()
});

export default router;
