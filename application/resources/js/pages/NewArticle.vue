<template>
    <div class="update-article-wrapper">
        <article-popup
            :message="'Article number '.concat(getNewArticle?.id, ' successfully created!')"
            :h2-message="'New article'"
            :is-popup-open="getIsPopupUpdatedOpen"
            v-on:close-popup="popupClosed"
        ></article-popup>
        <h1>New article</h1>
        <article-editor
            :article="getArticle"
            :article-error="getArticleUpdateError"
            :article-error-message="getArticleErrorMessage"
            :is-article-dirty="getIsArticleDirty"
            :is-article-updating="getIsArticleUpdating"
            v-on:set-article-dirty="setIsArticleDirty"
            v-on:update-article="storeArticle"
        ></article-editor>
    </div>
</template>

<script>

import PopupMessage from "../components/ArticlePopup.vue";
import ArticleEditor from "../components/ArticleEditor.vue";
import {mapGetters, mapActions, mapMutations} from 'vuex';

export default {
    name: "NewArticle",
    components: {ArticleEditor, PopupMessage},
    data: function () {
        return {
        }
    },
    methods: {
        onSubmit() {
            if (this.getIsArticleDirty) {
                this.storeArticle()
            }
        },
        popupClosed() {
            this.setIsPopupUpdatedOpen(false)
        },
        ...mapActions('newArticleModule', ['storeArticle']),
        ...mapMutations('newArticleModule', ['setIsArticleDirty', 'setIsPopupUpdatedOpen'])
    },
    computed: {
        ...mapGetters(
            'newArticleModule', [
                'getNewArticle',
                'getIsPopupUpdatedOpen',
                'getArticle',
                'getArticleUpdateError',
                'getArticleErrorMessage',
                'getIsArticleUpdating',
                'getIsArticleDirty',
            ])
    },
}
</script>

<style scoped>

</style>
