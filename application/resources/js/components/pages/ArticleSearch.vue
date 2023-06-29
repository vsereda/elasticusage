<template>
    <div class="article-search-wrapper">
        <update-article
            :article-id="articleIdForEdit"
            v-if="openEdit"
            @popup-closed="updatePopupClosed"
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
                <button @submit.prevent="getLoadSearchResults" :disabled="getIsArticleLoading">
                    Search
                </button>
            </form>
            <article-paginator
                :first-page-active="true"
                :prev-page-active="true"
                :next-page-active="true"
                :last-page-active="true"
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

            <div class="article-wrapper">
                <article v-for="item in getArticles" key="item.id" @click="openArticle(item.id)">
                    <h2 class="article-name" v-html="item.id.concat('. ', item.title)"></h2>
                    <p class="article-snippets" v-html="item.body_snippets"></p>
                    <p class="article-body">{{ item.body }}</p>
                </article>
            </div>
        </template>
    </div>
</template>

<script>
import useValidate from '@vuelidate/core'
import UpdateArticle from "../UI/UpdateArticle.vue";
import ArticlePaginator from "../UI/ArticlePaginator.vue";
import {required, minLength, maxLength} from '@vuelidate/validators'
import {mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    name: "ArticleSearch",
    components: {UpdateArticle, ArticlePaginator,},
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
                this.loadSearchResults(this.v$)
            } else {
                // Form failed validation
            }
        },
        openArticle(id) {
            this.setArticleIdForEdit(parseInt(id))
            this.openEdit = true
        },
        updatePopupClosed() {
            this.setSearchString(this.getResultsSearchString)
            this.requireSearchResults()
            this.openEdit = false
        },
        ...mapMutations('searchArticleModule', [
            'setArticleIdForEdit',
            'setSearchString',
        ]),
        ...mapActions('searchArticleModule', [
            'loadSearchResults',
        ])
    },
    computed: {
        ...mapGetters('searchArticleModule', [
            'getIsArticleLoading',
            'getSearchString',
            'getLoadSearchResults',
            'getArticles',
            'getResultsSearchString',
            'getIsArticlesDirty',
            'getArticleLoadingError',
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
