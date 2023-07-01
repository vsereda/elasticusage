<template>
    <div class="article-wrapper">
        <article v-for="item in articles" key="item.id"
                 @click="this.$emit('openArticle', item.id)">
            <div class="article-top">
                <h2 class="article-name" v-html="''.concat(item.id, '. ', item.title)"></h2>
                <div class="drop-button-wrapper" v-show="!isDropPopupOpen">
                    <a
                        href="#"
                        class="drop-article"
                        @click.prevent.stop="clickDrop(item.id)"
                        title="Drop this article"
                        v-show="useDropButton"
                    ></a>
                    <span class="drop-article-title" v-show="useDropButton">Drop</span>
                </div>
            </div>
            <p class="article-body">{{ item.body }}</p>
        </article>
        <article-popup
            :message="popupMessage"
            :h2-message="'Delete article'"
            :is-popup-open="isDropPopupOpen"
            :enable-dialog-y-n="useDialogYesNo"
            @close-popup="this.isDropPopupOpen = false"
            @no-answer="this.isDropPopupOpen = false"
            @yes-answer="dropConfirmed"
        ></article-popup>
    </div>
</template>

<script>

import PopupMessage from "./ArticlePopup.vue";
import globalArticles from "../../mixins/globalArticles";

export default {
    name: "ArticleList",
    components: {PopupMessage,},
    mixins: [ globalArticles ],
    data: function () {
        return {
            isDropPopupOpen: false,
            articleIdForDrop: 1,
            popupMessage: '',
            useDialogYesNo: false,
            dropArticleURL: '/api/articles',
        }
    },
    props: {
        articles: {
            "type": Object,
            "required": true,
        },
        useDropButton: {
            type: Boolean,
            default: false,
        },
    },
    methods: {
        clickDrop(id) {
            this.articleIdForDrop = id
            this.popupMessage = ('Do you really want to drop article '.concat(id, '?'))
            this.useDialogYesNo = true
            this.isDropPopupOpen = true
        },
        dropConfirmed() {
            this.useDialogYesNo = false
            this.dropArticle(this.articleIdForDrop)
        },
        dropArticle(id) {
            axios.delete(this.dropArticleURL.concat('/', id)).then(
                (response) => {
                    if (response?.data?.article?.id > 0) {
                        this.reloadAllArticles(this.$store)
                        this.popupMessage = 'Article '.concat(response.data.article.id, ' successfully deleted!')
                    }
                }
            ).catch(
                this.popupMessage = 'Drop article error!'
            )
        },
    },
}
</script>

<style scoped>
</style>
