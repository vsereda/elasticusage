<template>
    <div>
        <h1 class="zalupa">Search an articles</h1>
        <form v-on:submit.prevent="onFormSubmit">
            <input type="text" name="search-string" :disabled="isArticleLoading" v-model="searchString">
            <button v-on:submit.prevent="onFormSubmit" :disabled="isArticleLoading || searchString.length < this.searchStrMinLength">
                Search
            </button>
        </form>
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
            <article v-for="item in articles">
                <h2 class="article-name" v-html="item.id.concat('. ', item.title)"></h2>
                <p class="article-snippets" v-html="item.body_snippets"></p>
                <p class="article-body">{{ item.body }}</p>
            </article>
        </div>
    </div>
</template>

<script>
export default {
    name: "ArticleSearch",
    data: function () {
        return {
            searchString: '',
            searchStringInTitle: '',
            articles: [],
            isArticlesDirty: false,
            isArticleLoading: false,
            articleLoadingError: false,
            searchStrMinLength: 2,
        }
    },
    methods: {
        async onFormSubmit() {
            try {
                this.articles = []
                this.isArticleLoading = true
                this.isArticlesDirty = true
                this.searchStringInTitle = ''
                const response = await axios.post('api/articles/search', {
                    search_string: this.searchString,
                },)
                this.articles = response.data
            } catch (e) {
                this.articleLoadingError = true
            } finally {
                this.isArticleLoading = false
                this.searchStringInTitle = this.searchString
                this.searchString = ''
            }
        },
    },
    mounted() {
    }
}
</script>

<style scoped>
</style>
