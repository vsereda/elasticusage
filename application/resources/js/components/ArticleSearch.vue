<template>
    <div>
        <h1 class="zalupa">Search articles</h1>
        <form v-on:submit.prevent="onFormSubmit">
            <input type="text">
            <button v-on:submit.prevent="onFormSubmit">Search</button>
        </form>
        <p class="results-title" v-if="articles.length > 0">
            Search results for "<span>name</span>":
        </p>
        <p class="results-title" v-else-if="isArticlesDirty" >
            There are no search results for "<span>name</span>":
        </p>
        <div class="article-wrapper">
            <article v-for="item in articles">
                <h2 class="article-name" v-html="item.title"></h2>
                <p class="article-body" v-html="item.body"></p>
            </article>
        </div>
    </div>
</template>

<script>
export default {
    name: "ArticleSearch",
    data: function () {
        return {
            articles: [],
            isArticlesDirty: false,
        }
    },
    methods: {
        onFormSubmit() {
            alert('submit')
        },
    },
    mounted() {
        this.articles.push(
            { title: 'Article <span>name</span>', body: 'vjhefg ehdrfhg jkfgverdr jffehjej fejhj <span>name</span> jhekfulegh jehgrfh'},
            { title: 'Article <span>name</span>', body: 'vjhefg ehdrfhg jkfgverdr jffehjej fejhj <span>name</span> jhekfulegh jehgrfh'},
        );
    }
}
</script>

<style scoped>
</style>
