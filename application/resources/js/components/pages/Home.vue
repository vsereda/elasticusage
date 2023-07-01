<template>
    <div>
        <update-article :article-id="articleIdForEdit" v-if="openEdit" @popup-closed="updateClosed">
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
                :use-drop-button="true"
                @open-article="openArticle"
            >
            </article-list>
        </template>
    </div>
</template>

<script>

import UpdateArticle from "../UI/UpdateArticle.vue";
import ArticleList from "../UI/ArticleList.vue";
import {mapGetters, mapActions, mapMutations} from 'vuex';
import ArticlePaginator from "../UI/ArticlePaginator.vue";

export default {
    name: "Home",
    components: {ArticlePaginator, UpdateArticle, ArticleList},
    data: function () {
        return {
            articleIdForEdit: 1,
            openEdit: false,
        }
    },
    methods: {
        openArticle(id) {
            this.articleIdForEdit = id
            this.openEdit = true
        },
        updateClosed() {
            this.openEdit = false
        },
        ...mapMutations('homeArticlesModule', [
        ]),
        ...mapActions('homeArticlesModule', [
            'loadArticles',
            'loadLastArticles',
            'loadNextArticles',
            'loadPreviousArticles',
            'loadFirstArticles',
            'loadCurrentArticles',
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
            'getArticles',
        ])
    },
    mounted() {
    }
}
</script>

<style scoped>
</style>
