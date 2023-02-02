<template>
    <div>
        <popup-message
            :message="'Article '.concat(this.article?.id, ' successfully updated!')"
            :is-popup-open="isPopupUpdatedOpen"
            v-on:close-popup="popupClosed"
        ></popup-message>
        <h1>Article for update {{ $route.params.id }}</h1>
        <div class="article-wrapper">
            <h2 class="load-error" v-show="articleLoadingError">Loading Error!</h2>
            <h2 class="update-error" v-show="articleUpdateError">Updating Error!</h2>
            <article class="article-editor">
                <form @submit.prevent="onSubmit">
                    <label for="title-edit" class="title-label">Title</label>
                    <input id="title-edit" class="title-edit" type="text" name="title" v-model="article.title">
                    <label for="body-edit" class="body-label">Body</label>
                    <textarea id="body-edit" class="body-edit" v-model="article.body" rows="10"></textarea>
                    <button class="save-article" type="submit" :disabled="!isArticleDirty || isArticleUpdating">
                        Save article
                    </button>
                </form>
            </article>
        </div>
    </div>
</template>

<script>

import PopupMessage from "../components/PopupMessage.vue";

export default {
    name: "UpdateArticle",
    components: {PopupMessage},
    data: function () {
        return {
            article: {},
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
                const response = await axios.get('api/articles/'.concat(this.$route.params.id))
                this.article = response.data
                this.isArticleDirty = false
            } catch (e) {
                this.articleLoadingError = true
            } finally {
                this.isArticleLoading = false
            }
        },
        async updateArticle() {
            try {
                this.isArticleUpdating = true
                const response = await axios.put('api/articles/'.concat(this.$route.params.id), this.article)
                if (response.data?.success === true) {
                    this.isPopupUpdatedOpen = true
                    this.isArticleDirty = false
                }
                this.articleUpdateError = false
            } catch (e) {
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
        }
    },
    watch: {
        article: {
            handler(newVal, oldVal) {
                if (Object.keys(oldVal).length > 0 && Object.keys(newVal).length > 0) {
                    this.isArticleDirty = true
                }
            },
            deep: true
        }
    },
    mounted() {
        this.loadArticle()
    }
}
</script>

<style scoped>

</style>
