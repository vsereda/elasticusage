<template>
    <div class="article-wrapper">
        <h2 class="load-error" v-show="articleError">{{ articleErrorMessage }}</h2>
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
</template>

<script>
export default {
    name: "ArticleEditor",
    props: {
        article: {
            "type": Object,
            "required": true,
        },
        articleError: {
            "type": Boolean,
            "required": true,
        },
        articleErrorMessage: {
            "type": String,
            "required": true,
        },
        isArticleDirty: {
            "type": Boolean,
            "required": true,
        },
        isArticleUpdating: {
            "type": Boolean,
            "required": true,
        },
    },
    methods: {
        onSubmit() {
            if (this.isArticleDirty) {
                this.$emit('update-article', this.article)
            }
        },
    },
    watch: {
        article: {
            handler(newVal, oldVal) {
                if (Object.keys(oldVal).length > 0 && Object.keys(newVal).length > 0) {
                    this.$emit('set-article-dirty', true)
                }
            },
            deep: true
        }
    },
}
</script>

<style scoped>

</style>
