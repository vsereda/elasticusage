<template>
    <div class="update-article-wrapper">
        <popup-message
            :message="'Article number '.concat(this.articleId, ' successfully created!')"
            :is-popup-open="isPopupUpdatedOpen"
            v-on:close-popup="popupClosed"
        ></popup-message>
        <h1>New article</h1>
        <article-editor
            :article="article"
            :article-error="articleUpdateError || articleLoadingError"
            :article-error-message="articleErrorMessage"
            :is-article-dirty="isArticleDirty"
            :is-article-updating="isArticleUpdating"
            v-on:set-article-dirty="setArticleDirty"
            v-on:update-article="storeArticle"
        ></article-editor>
    </div>
</template>

<script>

import PopupMessage from "../components/PopupMessage.vue";
import ArticleEditor from "../components/ArticleEditor.vue";

export default {
    name: "NewArticle",
    components: {ArticleEditor, PopupMessage},
    data: function () {
        return {
            article: {},
            articleId: 1,
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
        async storeArticle(articleNew) {
            try {
                this.isArticleUpdating = true
                const response = await axios.post('api/articles', articleNew)
                console.log(response)
                if (response.data?.success === true && response.data?.article_id > 0 ) {
                    this.articleId = response.data.article_id
                    this.isPopupUpdatedOpen = true
                    this.isArticleDirty = false
                    this.article = {}
                }
                this.articleUpdateError = false
            } catch (e) {
                this.articleErrorMessage = 'Article create error'
                this.articleUpdateError = true
            } finally {
                this.isArticleUpdating = false
            }
        },
        onSubmit() {
            if (this.isArticleDirty) {
                this.storeArticle()
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
    }
}
</script>

<style scoped>

</style>
