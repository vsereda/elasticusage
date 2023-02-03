<template>
    <div>
        <popup-message
            :message="popupMessage"
            :h2-message="'Dropping an article'"
            :is-popup-open="isDropPopupOpen"
            :enable-dialog-y-n="enableDialogYN"
            v-on:close-popup="this.isDropPopupOpen = false"
            v-on:no-answer="this.isDropPopupOpen = false"
            v-on:yes-answer="confirmedDrop"
        ></popup-message>
        <update-article
            :article-id="articleIdForEdit"
            v-if="openEdit"
            v-on:popup-closed="updatePopupClosed"
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
                    <div class="article-top">
                        <h2 class="article-name" v-html="''.concat(item.id, '. ', item.title)"></h2>
                        <a
                            href="#"
                            class="drop-article"
                            @click.prevent.stop="clickDropButton(item.id)"
                            title="Drop this article"
                            v-show="!isDropPopupOpen"
                        ></a>
                    </div>
                    <p class="article-body">{{ item.body }}</p>
                </article>
            </div>
        </template>
    </div>
</template>

<script>

import UpdateArticle from "./UpdateArticle.vue";
import PopupMessage from "../components/PopupMessage.vue";

export default {
    name: "Home",
    components: {PopupMessage, UpdateArticle},
    data: function () {
        return {
            articleIdForEdit: 1,
            articleIdForDrop: 1,
            articleLoadingError: false,
            articles: [],
            currentPageUrl: '',
            dropArticleURL: '/api/articles',
            enableDialogYN: false,
            firstPageActive: false,
            isArticleLoading: false,
            isArticlesDirty: false,
            isDropPopupOpen: false,
            lastPageActive: false,
            loadArticlesURL: '/api/articles',
            nextPageActive: false,
            openEdit: false,
            popupMessage: '',
            prevPageActive: false,
            response: {},
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
        async confirmedDrop() {
            this.enableDialogYN = false
            try {
                const response = await axios.delete(this.dropArticleURL.concat('/', this.articleIdForDrop))
                if (response?.data?.success === true) {
                    this.loadCurrentArticles()
                    this.popupMessage = 'Article '.concat(this.articleIdForDrop, ' successfully deleted!')
                }
            } catch (e) {
                this.popupMessage = 'Drop article error!'
            } finally {
            }
        },
        clickDropButton(id) {
            this.articleIdForDrop = id
            this.popupMessage = 'Do you really want to drop article '. concat(id, '?')
            this.enableDialogYN = true
            this.isDropPopupOpen = true
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
        updatePopupClosed() {
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
