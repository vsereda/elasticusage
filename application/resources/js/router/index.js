import {createRouter, createWebHistory} from "vue-router";

import Home from "../components/pages/Home.vue";
import NewArticle from "../components/pages/NewArticle.vue";
import ArticleSearch from "../components/pages/ArticleSearch.vue";
import PageNotFound from "../components/pages/PageNotFound.vue";

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
