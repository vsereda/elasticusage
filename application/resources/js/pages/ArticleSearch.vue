<template>
    <div class="article-search-wrapper">
        <update-article
            :article-id="articleIdForEdit"
            v-if="openEdit"
            v-on:popup-closed="updatePopupClosed"
        ></update-article>
        <template v-else>
            <h1>Article search</h1>
            <form v-on:submit.prevent="loadSearchResults" class="search-articles-form">
                <input
                    type="text"
                    name="search-string"
                    :disabled="isArticleLoading"
                    v-model="searchString"
                    :class="{ 'search-field-error': v$.searchString.$errors.length }"
                >
                <button v-on:submit.prevent="loadSearchResults" :disabled="isArticleLoading">
                    Search
                </button>
            </form>
            <div class="input-errors" v-for="(error, index) of v$.searchString.$errors" :key="index">
                <p class="search-valid-error">{{ error.$message }}</p>
            </div>
            <template v-if="!isArticleLoading">
                <p class="results-title" v-if="articles.length > 0">
                    Search results for "<span>{{ searchStringInTitle }}</span>":
                </p>
                <p class="results-title" v-else-if="isArticlesDirty && !articleLoadingError">
                    There are no search results for "<span>{{ searchStringInTitle }}</span>":
                </p>
                <p class="results-title" v-else-if="isArticlesDirty && articleLoadingError">
                    Search results loading error
                </p>
            </template>
            <p class="results-title" v-else>
                Loading search results...
            </p>

            <div class="article-wrapper">
                <article v-for="item in articles" key="item.id" @click="openArticle(item.id)">
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
import UpdateArticle from "../components/UpdateArticle.vue";
import {required, minLength, maxLength} from '@vuelidate/validators'

export default {
    name: "ArticleSearch",
    components: {UpdateArticle,},
    data: function () {
        return {
            v$: useValidate(),
            articleIdForEdit: 1,
            searchString: '',
            searchStringInTitle: '',
            articles: [],
            isArticlesDirty: false,
            isArticleLoading: false,
            articleLoadingError: false,
            openEdit: false,
        }
    },
    methods: {
        async loadSearchResults() {
            this.v$.$validate()
            if (!this.v$.$error) {
                try {
                    this.articles = []
                    this.isArticleLoading = true
                    this.isArticlesDirty = true
                    this.searchStringInTitle = ''
                    const response = await axios.post('api/articles/search', {
                        search_phrase: this.searchString,
                    },)
                    this.articles = response?.data?.articles
                } catch (e) {
                    this.articleLoadingError = true
                } finally {
                    this.isArticleLoading = false
                    this.searchStringInTitle = this.searchString
                    this.searchString = ''
                    this.v$.$reset()
                }
            } else {
                // Form failed validation
            }
        },
        openArticle(id) {
            this.articleIdForEdit = parseInt(id)
            this.openEdit = true
        },
        updatePopupClosed() {
            this.searchString = this.searchStringInTitle
            this.loadSearchResults()
            this.openEdit = false
        }
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
