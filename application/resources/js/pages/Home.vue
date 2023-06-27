<template>
    <div>
        <popup-message
            :message="popupMessage"
            :h2-message="'Dropping an article'"
            :is-popup-open="isDropPopupOpen"
            :enable-dialog-y-n="enableDialogYN"
            v-on:close-popup="this.isDropPopupOpen = false"
            v-on:no-answer="this.isDropPopupOpen = false"
            v-on:yes-answer="dropArticle"
        ></popup-message>
        <update-article :article-id="articleIdForEdit" v-if="openEdit"
                        v-on:popup-closed="updatePopupClosed"></update-article>
        <template v-else>
            <h1>List of articles page {{ getMeta?.current_page ?? 1 }}</h1>
            <nav class="articles-list-paginator">
                <button @click="loadFirstArticles" :disabled="!firstPageActive">first</button>
                <button @click="loadPreviousArticles" :disabled="!prevPageActive">previous
                </button>
                <button @click="loadNextArticles" :disabled="!nextPageActive">next</button>
                <button @click="loadLastArticles" :disabled="!lastPageActive">last</button>
            </nav>
            <template v-if="!getIsArticleLoading">
                <p class="results-title" v-if="noArticles">
                    There are no articles
                </p>
                <p class="results-title" v-else-if="showArticleLoadingError">
                    Search results loading error
                </p>
            </template>

            <div class="article-wrapper">
                <article v-for="item in getArticles" key="item.id" @click="openArticle(item.id)">
                    <div class="article-top">
                        <h2 class="article-name" v-html="''.concat(item.id, '. ', item.title)"></h2>
                        <div class="drop-button-wrapper" v-show="!isDropPopupOpen">
                            <a
                                href="#"
                                class="drop-article"
                                @click.prevent.stop="clickDropButton(item.id)"
                                title="Drop this article"
                            ></a>
                            <span class="drop-article-title">Drop</span>
                        </div>
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
import {mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    name: "Home",
    components: {PopupMessage, UpdateArticle},
    data: function () {
        return {
            articleIdForEdit: 1,
            articleIdForDrop: 1,
            dropArticleURL: '/api/articles',
            enableDialogYN: false,
            isDropPopupOpen: false,
            loadArticlesURL: '/api/articles',
            openEdit: false,
            popupMessage: '',
        }
    },
    methods: {
        async dropArticle() {
            this.enableDialogYN = false
            try {
                const response = await axios.delete(this.dropArticleURL.concat('/', this.articleIdForDrop))
                if (response?.data?.article?.id > 0) {
                    this.loadCurrentArticles()
                    this.popupMessage = 'Article '.concat(response.data.article.id, ' successfully deleted!')
                }
            } catch (e) {
                this.popupMessage = 'Drop article error!'
            } finally {
            }
        },
        clickDropButton(id) {
            this.articleIdForDrop = id
            this.popupMessage = 'Do you really want to drop article '.concat(id, '?')
            this.enableDialogYN = true
            this.isDropPopupOpen = true
        },
        openArticle(id) {
            this.articleIdForEdit = id
            this.openEdit = true
        },
        updatePopupClosed() {
            this.loadCurrentArticles()
            this.openEdit = false
        },
        ...mapMutations('homeArticlesModule', ['setArticles', 'setArticleLoadingError', 'setMeta', 'setLinks', 'setIsArticlesDirty', 'setIsArticleLoading']),
        ...mapActions('homeArticlesModule', ['loadArticles', 'loadLastArticles', 'loadNextArticles', 'loadPreviousArticles', 'loadFirstArticles', 'loadCurrentArticles'])
    },
    computed: {
        ...mapGetters('homeArticlesModule', ['getArticles', 'getArticlesLoadingError', 'getMeta', 'firstPageActive',
            'getLinks', 'getIsArticlesDirty', 'prevPageActive', 'nextPageActive', 'lastPageActive', 'noArticles', 'getIsArticleLoading',
            'showArticleLoadingError'])
    },
    mounted() {
        this.loadArticles(this.loadArticlesURL)
    }
}
</script>

<style scoped>
</style>
