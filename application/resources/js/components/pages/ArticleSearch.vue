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
                    :disabled="getIsArticleLoading"
                    v-model="searchString"
                    :class="{ 'search-field-error': v$.searchString.$errors.length }"
                >
                <button @submit.prevent="requireSearchResults" :disabled="getIsArticleLoading">
                    Search
                </button>
            </form>
            <article-paginator
                :first-page-active="firstPageActive"
                :prev-page-active="prevPageActive"
                :next-page-active="nextPageActive"
                :last-page-active="lastPageActive"
                :show-paginator="getMeta?.last_page > 1"
                :current-page="getMeta?.current_page"
                :last-page="getMeta?.last_page"
                @load-first-articles="loadFirstArticles"
                @load-previous-articles="loadPreviousArticles"
                @load-next-articles="loadNextArticles"
                @load-last-articles="loadLastArticles"
            ></article-paginator>
            <div class="input-errors" v-for="(error, index) of v$.searchString.$errors" :key="index">
                <p class="search-valid-error">{{ error.$message }}</p>
            </div>
            <template v-if="!getIsArticleLoading">
                <p class="results-title" v-if="getArticles.length > 0">
                    Search results for "<span>{{ getResultsSearchString }}</span>":
                </p>
                <p class="results-title" v-else-if="getIsArticlesDirty && !getArticleLoadingError">
                    There are no search results for "<span>{{ getResultsSearchString }}</span>":
                </p>
                <p class="results-title" v-else-if="getIsArticlesDirty && getArticleLoadingError">
                    Search results loading error
                </p>
            </template>
            <p class="results-title" v-else>
                Loading search results...
            </p>
            <article-list
                :articles="getArticles"
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
                this.loadSearchResults({url: this.getSearchArticleURL, searchStr: this.getSearchString, reset: true})
            } else {
                // Form failed validation
            }
        },
        openArticle(id) {
            this.articleIdForEdit = parseInt(id)
            this.openEdit = true
        },
        updatePopupClosed() {
            this.setSearchString(this.getResultsSearchString)
            this.openEdit = false
        },
        ...mapMutations('searchArticleModule', [
            'setSearchString',
        ]),
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
        ...mapGetters('searchArticleModule', [
            'getIsArticleLoading',
            'getSearchString',
            'getSearchArticleURL',
            'getArticles',
            'getResultsSearchString',
            'getIsArticlesDirty',
            'getArticleLoadingError',
            'lastPageActive',
            'nextPageActive',
            'prevPageActive',
            'firstPageActive',
            'getLinks',
            'getMeta',
        ]),
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
