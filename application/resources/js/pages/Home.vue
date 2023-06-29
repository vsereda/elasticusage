<template>
    <div>
        <article-popup
            :message="getPopupMessage"
            :h2-message="'Deleting an article'"
            :is-popup-open="isDropPopupOpen"
            :enable-dialog-y-n="useDialogYesNo"
            v-on:close-popup="this.isDropPopupOpen = false"
            v-on:no-answer="this.isDropPopupOpen = false"
            v-on:yes-answer="onDropConfirmed"
        ></article-popup>
        <update-article :article-id="articleIdForEdit" v-if="openEdit" v-on:popup-closed="updatePopupClosed">
        </update-article>
        <template v-else>
            <h1>List of articles page {{ getMeta?.current_page ?? 1 }}</h1>
            <nav class="articles-list-paginator">
                <button @click="loadFirstArticles" :disabled="!firstPageActive">first</button>
                <button @click="loadPreviousArticles" :disabled="!prevPageActive">previous</button>
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
            <article-list @open-article="openArticle" @click-drop="onClickDrop" :is-drop-popup-open="isDropPopupOpen">
            </article-list>
        </template>
    </div>
</template>

<script>

import UpdateArticle from "../components/UpdateArticle.vue";
import PopupMessage from "../components/ArticlePopup.vue";
import ArticleList from "../components/ArticleList.vue";
import {mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    name: "Home",
    components: {PopupMessage, UpdateArticle, ArticleList},
    data: function () {
        return {
            articleIdForEdit: 1,
            articleIdForDrop: 1,
            useDialogYesNo: false,
            isDropPopupOpen: false,
            openEdit: false,
        }
    },
    methods: {
        onDropConfirmed() {
            this.useDialogYesNo = false
            this.dropArticle(this.articleIdForDrop)
        },
        onClickDrop(id) {
            this.articleIdForDrop = id
            this.setPopupMessage('Do you really want to drop article '.concat(id, '?'))
            this.useDialogYesNo = true
            this.isDropPopupOpen = true
        },
        openArticle(id) {
            this.articleIdForEdit = id
            this.openEdit = true
        },
        updatePopupClosed() {
            // this.loadCurrentArticles()
            this.openEdit = false
        },
        ...mapMutations('homeArticlesModule', ['setPopupMessage']),
        ...mapActions('homeArticlesModule', [
            'loadArticles',
            'loadLastArticles',
            'loadNextArticles',
            'loadPreviousArticles',
            'loadFirstArticles',
            'loadCurrentArticles',
            'dropArticle'
        ])
    },
    computed: {
        ...mapGetters('homeArticlesModule', [
            'getMeta',
            'firstPageActive',
            'prevPageActive',
            'nextPageActive',
            'lastPageActive',
            'noArticles',
            'getIsArticleLoading',
            'showArticleLoadingError',
            'getPopupMessage'
        ])
    },
    mounted() {
    }
}
</script>

<style scoped>
</style>
