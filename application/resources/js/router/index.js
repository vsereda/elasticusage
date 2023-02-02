import {createRouter, createWebHistory} from "vue-router";

import Home from "../pages/Home.vue";
import UpdateArticle from "../pages/UpdateArticle.vue";
import NewArticle from "../pages/NewArticle.vue";
import ArticleSearch from "../pages/ArticleSearch.vue";

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
        path: '/articles/:id(\\d+)',
        component: UpdateArticle,
        name: 'article.edit',
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
