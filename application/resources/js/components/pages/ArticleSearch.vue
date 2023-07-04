<template>
    <div class="article-search-wrapper">
        <update-article
            :article-id="articleIdForEdit"
            v-if="openEdit"
            @popup-closed="updatePopupClosed"
            @update-article="updateArticle"
        ></update-article>
        <template v-else>
            <h1>Article search</h1>
            <form @submit.prevent="requireSearchResults" class="search-articles-form">
                <input
                    type="text"
                    name="search-string"
                    :disabled="isArticleLoading"
                    v-model="searchString"
                    :class="{ 'search-field-error': v$.searchString.$errors.length }"
                >
                <button @submit.prevent="requireSearchResults" :disabled="isArticleLoading">
                    Search
                </button>
            </form>
            <article-paginator
                :first-page-active="firstPageActive"
                :prev-page-active="prevPageActive"
                :next-page-active="nextPageActive"
                :last-page-active="lastPageActive"
                :show-paginator="meta?.last_page > 1"
                :current-page="meta?.current_page"
                :last-page="meta?.last_page"
                @load-first-articles="loadFirstArticles"
                @load-previous-articles="loadPreviousArticles"
                @load-next-articles="loadNextArticles"
                @load-last-articles="loadLastArticles"
            ></article-paginator>
            <div class="input-errors" v-for="(error, index) of v$.searchString.$errors" :key="index">
                <p class="search-valid-error">{{ error.$message }}</p>
            </div>
            <template v-if="!isArticleLoading">
                <p class="results-title" v-if="articles.length > 0">
                    Search results for "<span>{{ resultsSearchString }}</span> ({{ meta?.total }})":
                </p>
                <p class="results-title" v-else-if="isArticlesDirty && !articleLoadingError">
                    There are no search results for "<span>{{ resultsSearchString }}</span>":
                </p>
                <p class="results-title" v-else-if="isArticlesDirty && articleLoadingError">
                    Search results loading error
                </p>
            </template>
            <p class="results-title" v-else>
                Loading search results...
            </p>
            <article-list
                :articles="articles"
                :is-drop-popup-open="false"
                :use-drop-button="true"
                @open-article="openArticle"
            >
            </article-list>

        </template>
    </div>
</template>

<script>
import useValidate from '@vuelidate/core'
import UpdateArticle from "../UI/UpdateArticle.vue";
import ArticlePaginator from "../UI/ArticlePaginator.vue";
import ArticleList from "../UI/ArticleList.vue";

import {required, minLength, maxLength, integer} from '@vuelidate/validators'
import {mapGetters, mapActions, mapMutations} from 'vuex';
import ArticleEditor from "../UI/ArticleEditor.vue";

export default {
    name: "ArticleSearch",
    components: {ArticleEditor, UpdateArticle, ArticlePaginator, ArticleList},
    data: function () {
        return {
            v$: useValidate(),
            articleIdForEdit: 1,
            openEdit: false,
        }
    },
    methods: {
        requireSearchResults() {
            this.v$.$validate()
            if (!this.v$.$error) {
                this.v$.$reset()
                this.loadSearchResults({url: this.searchArticleURL, searchStr: this.getSearchString, reset: true})
            } else {
                // Form failed validation
            }
        },
        openArticle(id) {
            this.articleIdForEdit = parseInt(id)
            this.openEdit = true
        },
        updatePopupClosed() {
            this.setSearchString(this.resultsSearchString)
            this.openEdit = false
        },
        ...mapMutations('searchArticleModule', {
            setSearchString: 'SET_SEARCH_STRING' ,
        }),
        ...mapActions('searchArticleModule', [
            'loadSearchResults',
            'loadLastArticles',
            'loadNextArticles',
            'loadPreviousArticles',
            'loadFirstArticles',
        ])
    },
    computed: {
        integer() {
            return integer
        },
        ...mapGetters('searchArticleModule', {
            isArticleLoading: 'GET_ARTICLE_LOADING',
            getSearchString: 'GET_SEARCH_STRING',
            searchArticleURL: 'GET_SEARCH_ARTICLE_URL',
            articles: 'GET_ARTICLES',
            resultsSearchString: 'GET_RESULT_SEARCH_STRING',
            isArticlesDirty: 'GET_ARTICLE_DIRTY',
            articleLoadingError: 'GET_ARTICLE_LOADING_ERROR',
            lastPageActive: 'GET_LAST_PAGE_ACTIVE',
            nextPageActive: 'GET_NEXT_PAGE_ACTIVE',
            prevPageActive: 'GET_PREV_PAGE_ACTIVE',
            firstPageActive: 'GET_FIRST_PAGE_ACTIVE',
            meta: 'GET_META',
        }),
        searchString: {
            get: function () {
                return this.getSearchString
            },
            set: function (newValue) {
                this.setSearchString(newValue)
            }
        },
    },
    validations() {
        return {
            searchString: {
                required,
                min: minLength(3),
                max: maxLength(100),
            },
        }
    },
    mounted() {
    },
}
</script>

<style scoped>
</style>
