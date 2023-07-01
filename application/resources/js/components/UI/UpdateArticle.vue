<template>
    <div class="update-article-wrapper">
        <article-popup
            :message="'Article '.concat(article?.id, ' successfully updated!')"
            :h2-message="'Updating article'"
            :is-popup-open="isPopupUpdatedOpen"
            @close-popup="popupClosed"
        ></article-popup>
        <h1>Update article {{ articleId }}</h1>
        <article-editor
            :article="article"
            :article-error="articleUpdateError || articleLoadingError"
            :article-error-message="articleErrorMessage"
            :is-article-dirty="isArticleDirty"
            :is-article-updating="isArticleUpdating"
            @set-article-dirty="setArticleDirty"
            @update-article="updateArticle"
        ></article-editor>
        <a
            href="#"
            class="close-article"
            @click.prevent="popupClosed"
            v-show="!isPopupUpdatedOpen"
        ></a>
        <span class="close-article-title" v-show="!isPopupUpdatedOpen">
            Close
        </span>
    </div>
</template>

<script>

import PopupMessage from "./ArticlePopup.vue";
import ArticleEditor from "./ArticleEditor.vue";
// import {mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    name: "UpdateArticle",
    components: {ArticleEditor, PopupMessage},
    props: {
        articleId: {
            "type": Number,
            "required": true,
        }
    },
    data: function () {
        return {
            isArticleLoading: false,
            article: {},
            isArticleDirty: false,
            articleErrorMessage: '',
            articleLoadingError: false,
            isArticleUpdating: false,
            isPopupUpdatedOpen: false,
            articleUpdateError: false,
        }
    },
    methods: {
        onSubmit() {
            if (this.isArticleDirty) {
                this.updateArticle()
            }
        },
        popupClosed() {
            this.isPopupUpdatedOpen = false
            this.$emit('popup-closed')
        },
        updateArticle(article) {
            try {
                this.isArticleUpdating = true
                axios.put('api/articles/'.concat(article.id), article).then((response) => {
                    if (response.data?.article?.id > 0) {
                        this.isPopupUpdatedOpen = true
                        this.isArticleDirty = false
                    }
                    this.$store.dispatch('homeArticlesModule/loadCurrentArticles', null, {root: true})
                    setTimeout(() => {
                        // timeout needed for update search index
                        this.$store.dispatch('searchArticleModule/loadCurrentArticles', null, {root: true})
                    }, 2000)
                    this.articleUpdateError = false
                })
            } catch (e) {
                this.articleErrorMessage = 'Article update error'
                this.articleUpdateError = true
            } finally {
                this.isArticleUpdating = false
            }
        },
        loadArticle(id) {
            this.isArticleLoading = true
            axios.get('api/articles/'.concat(id)).then((response) => {
                this.article = response.data?.article
                this.isArticleDirty = false
            }).catch(() => {
                this.articleErrorMessage = 'Article load error'
                this.articleLoadingError = true
            }).finally(() => {
                this.isArticleLoading = false
            })
        },
        setArticleDirty(isDirty) {
            this.isArticleDirty = isDirty
        }
    },
    computed: {},
    mounted() {
        this.loadArticle(this.articleId)
    }
}
</script>

<style scoped>

</style>
