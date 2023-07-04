<template>
    <div class="update-article-wrapper">
        <article-popup
            :message="'Article number '.concat(newArticle?.id, ' successfully created!')"
            :h2-message="'New article'"
            :is-popup-open="popupUpdatedOpened"
            @close-popup="popupClosed"
        ></article-popup>
        <h1>New article</h1>
        <article-editor
            :article="article"
            :article-error="articleUpdateError"
            :article-error-message="articleErrorMessage"
            :is-article-dirty="isArticleDirty"
            :is-article-updating="isArticleUpdating"
            @set-article-dirty="SET_ARTICLE_DIRTY"
            @update-article="storeArticle"
        ></article-editor>
    </div>
</template>

<script>

import PopupMessage from "../UI/ArticlePopup.vue";
import ArticleEditor from "../UI/ArticleEditor.vue";
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
            if (this.isArticleDirty) {
                this.storeArticle()
            }
        },
        popupClosed() {
            this.SET_POPUP_UPDATE_OPEN(false)
        },
        ...mapActions('newArticleModule', ['storeArticle']),
        ...mapMutations('newArticleModule', ['SET_ARTICLE_DIRTY', 'SET_POPUP_UPDATE_OPEN'])
    },
    computed: {
        ...mapGetters(
            'newArticleModule', {
                newArticle: 'getNewArticle',
                popupUpdatedOpened: 'getIsPopupUpdatedOpen',
                article: 'getArticle',
                articleUpdateError: 'getArticleUpdateError',
                articleErrorMessage: 'getArticleErrorMessage',
                isArticleUpdating: 'getIsArticleUpdating',
                isArticleDirty: 'getIsArticleDirty',
            })
    },
}
</script>

<style scoped>

</style>
