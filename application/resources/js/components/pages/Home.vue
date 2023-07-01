<template>
    <div>
        <article-popup
            :message="getPopupMessage"
            :h2-message="'Deleting an article'"
            :is-popup-open="isDropPopupOpen"
            :enable-dialog-y-n="useDialogYesNo"
            @close-popup="this.isDropPopupOpen = false"
            @no-answer="this.isDropPopupOpen = false"
            @yes-answer="onDropConfirmed"
        ></article-popup>
        <update-article :article-id="articleIdForEdit" v-if="openEdit" @popup-closed="updatePopupClosed">
        </update-article>
        <template v-else>
            <h1>List of articles page {{ getMeta?.current_page ?? 1 }}</h1>
            <article-paginator
                :last-page-active="lastPageActive"
                :next-page-active="nextPageActive"
                :prev-page-active="prevPageActive"
                :first-page-active="firstPageActive"
                @load-first-articles="loadFirstArticles"
                @load-previous-articles="loadPreviousArticles"
                @load-next-articles="loadNextArticles"
                @load-last-articles="loadLastArticles"
            >
            </article-paginator>
            <template v-if="!getIsArticleLoading">
                <p class="results-title" v-if="noArticles">
                    There are no articles
                </p>
                <p class="results-title" v-else-if="showArticleLoadingError">
                    Search results loading error
                </p>
            </template>
            <article-list
                :articles="getArticles"
                :is-drop-popup-open="isDropPopupOpen"
                @open-article="openArticle"
                @click-drop="onClickDrop"
            >
            </article-list>
        </template>
    </div>
</template>

<script>

import UpdateArticle from "../UI/UpdateArticle.vue";
import PopupMessage from "../UI/ArticlePopup.vue";
import ArticleList from "../UI/ArticleList.vue";
import {mapGetters, mapActions, mapMutations} from 'vuex';
import ArticlePaginator from "../UI/ArticlePaginator.vue";

export default {
    name: "Home",
    components: {ArticlePaginator, PopupMessage, UpdateArticle, ArticleList},
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
            'getPopupMessage',
            'getArticles',
        ])
    },
    mounted() {
    }
}
</script>

<style scoped>
</style>
