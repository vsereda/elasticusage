<template>
    <div class="update-article-wrapper">
        <popup-message
            :message="'Article '.concat(this.article?.id, ' successfully updated!')"
            :h2-message="'Updating article'"
            :is-popup-open="isPopupUpdatedOpen"
            v-on:close-popup="popupClosed"
        ></popup-message>
        <h1>Update article {{ articleId }}</h1>
        <article-editor
            :article="article"
            :article-error="articleUpdateError || articleLoadingError"
            :article-error-message="articleErrorMessage"
            :is-article-dirty="isArticleDirty"
            :is-article-updating="isArticleUpdating"
            v-on:set-article-dirty="setArticleDirty"
            v-on:update-article="updateArticle"
        ></article-editor>
        <a
            href="#"
            class="close-article"
            @click.prevent="popupClosed"
            v-show="!isPopupUpdatedOpen"
            title="Close this article"
        ></a>
    </div>
</template>

<script>

import PopupMessage from "../components/PopupMessage.vue";
import ArticleEditor from "../components/ArticleEditor.vue";

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
            article: {},
            articleErrorMessage: '',
            isArticleLoading: false,
            articleLoadingError: false,
            isArticleDirty: false,
            isArticleUpdating: false,
            articleUpdateError: false,
            isPopupUpdatedOpen: false,
        }
    },
    methods: {
        async loadArticle() {
            try {
                this.isArticleLoading = true
                const response = await axios.get('api/articles/'.concat(this.articleId))
                this.article = response.data
                this.isArticleDirty = false
            } catch (e) {
                this.articleErrorMessage = 'Article load error'
                this.articleLoadingError = true
            } finally {
                this.isArticleLoading = false
            }
        },
        async updateArticle(articleNewVersion) {
            try {
                this.isArticleUpdating = true
                const response = await axios.put('api/articles/'.concat(this.articleId), articleNewVersion)
                if (response.data?.success === true) {
                    this.isPopupUpdatedOpen = true
                    this.isArticleDirty = false
                }
                this.articleUpdateError = false
            } catch (e) {
                this.articleErrorMessage = 'Article update error'
                this.articleUpdateError = true
            } finally {
                this.isArticleUpdating = false
            }
        },
        onSubmit() {
            if (this.isArticleDirty) {
                this.updateArticle()
            }
        },
        popupClosed() {
            this.isPopupUpdatedOpen = false
            this.$emit('popup-closed')
        },
        setArticleDirty(isDirty) {
            this.isArticleDirty = isDirty
        }
    },
    mounted() {
        this.loadArticle()
    }
}
</script>

<style scoped>

</style>
