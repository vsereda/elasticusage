<template>
    <div>
        <update-article
            :article-id="articleIdForEdit"
            v-if="openEdit"
            v-on:popup-closed="popupClosed"
        ></update-article>
        <template v-else>
            <h1>List of articles page {{ response?.current_page ?? 1 }}</h1>
            <button @click="loadFirstArticles" :disabled="!firstPageActive || articles.length === 0">first</button>
            <button @click="loadPreviousArticles" :disabled="!prevPageActive || articles.length === 0">prev</button>
            <button @click="loadNextArticles" :disabled="!nextPageActive || articles.length === 0">next</button>
            <button @click="loadLastArticles" :disabled="!nextPageActive || articles.length === 0">last</button>

            <template v-if="!isArticleLoading">
                <p class="results-title" v-if="articles.length === 0 && isArticlesDirty && !articleLoadingError">
                    There are no articles
                </p>
                <p class="results-title" v-else-if="isArticlesDirty && articleLoadingError">
                    Search results loading error
                </p>
            </template>

            <div class="article-wrapper">
                <article v-for="item in articles" key="item.id" @click="openArticle(item.id)">
                    <h2 class="article-name" v-html="''.concat(item.id, '. ', item.title)"></h2>
                    <p class="article-body">{{ item.body }}</p>
                </article>
            </div>
        </template>
    </div>
</template>

<script>

import UpdateArticle from "./UpdateArticle.vue";

export default {
    name: "Home",
    components: {UpdateArticle},
    data: function () {
        return {
            articles: [],
            articleIdForEdit: 1,
            articleLoadingError: false,
            currentPageUrl: '',
            isArticlesDirty: false,
            isArticleLoading: false,
            loadArticlesURL: '/api/articles',
            response: {},
            nextPageActive: false,
            prevPageActive: false,
            firstPageActive: false,
            lastPageActive: false,
            openEdit: false,
        }
    },
    methods: {
        async loadArticles(url = this.loadArticlesURL) {
            this.currentPageUrl = url
            try {
                this.isArticleLoading = true
                this.isArticlesDirty = true
                const response = await axios.get(url)
                this.response = response.data
                if (this?.response?.data?.length > 0) {
                    this.articles = this.response.data
                }
            } catch (e) {
                this.articleLoadingError = true
            } finally {
                this.isArticleLoading = false
            }
        },
        loadCurrentArticles() {
            this.loadArticles(this.currentPageUrl)
        },
        loadFirstArticles() {
            this.loadArticles(this?.response?.first_page_url)
        },
        loadPreviousArticles() {
            this.loadArticles(this?.response?.prev_page_url)
        },
        loadNextArticles() {
            this.loadArticles(this?.response?.next_page_url)
        },
        loadLastArticles() {
            this.loadArticles(this?.response?.last_page_url)
        },
        openArticle(id) {
            this.articleIdForEdit = id
            this.openEdit = true
        },
        popupClosed() {
            this.loadCurrentArticles()
            this.openEdit = false
        }
    },
    watch: {
        response: {
            handler(newValue, oldValue) {
                this.firstPageActive = newValue?.current_page > 1;
                this.prevPageActive = newValue?.prev_page_url !== null;
                this.nextPageActive = newValue?.next_page_url !== null;
                this.lastPageActive = newValue?.current_page < newValue?.last_page;
            },
            deep: true
        }
    },
    mounted() {
        this.loadArticles()
    }
}
</script>

<style scoped>

</style>
