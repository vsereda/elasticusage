<template>
    <div>
        <h1>List of articles</h1>
        <button @click="loadFirstArticles" :disabled="!firstPageActive">first</button>
        <button @click="loadPreviousArticles" :disabled="!prevPageActive">prev</button>
        <button @click="loadNextArticles" :disabled="!nextPageActive">next</button>
        <button @click="loadLastArticles" :disabled="!nextPageActive">last</button>
        <div class="article-wrapper">
            <article v-for="item in articles" key="item.id">
                <h2 class="article-name" v-html="''.concat(item.id, '. ', item.title)"></h2>
                <p class="article-body">{{ item.body }}</p>
            </article>
        </div>
    </div>
</template>

<script>

export default {
    name: "Home",
    data: function () {
        return {
            articles: [],
            articleLoadingError: false,
            loadArticlesURL: '/api/articles',
            response: {},
            nextPageActive: false,
            prevPageActive: false,
            firstPageActive: false,
            lastPageActive: false,
        }
    },
    methods: {
        async loadArticles(url = this.loadArticlesURL) {
            try {
                const response = await axios.get(url)
                this.response = response.data
                if (this?.response?.data?.length > 0) {
                    this.articles = this.response.data
                }
            } catch (e) {
                this.articleLoadingError = true
            } finally {

            }
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
