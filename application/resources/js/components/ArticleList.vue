<template>
    <div class="article-wrapper">
        <article v-for="item in getArticles" key="item.id" @click="$emit('openArticle', item.id)">
            <div class="article-top">
                <h2 class="article-name" v-html="''.concat(item.id, '. ', item.title)"></h2>
                <div class="drop-button-wrapper" v-show="!isDropPopupOpen">
                    <a
                        href="#"
                        class="drop-article"
                        @click.prevent.stop="$emit('clickDrop', item.id)"
                        title="Drop this article"
                    ></a>
                    <span class="drop-article-title">Drop</span>
                </div>
            </div>
            <p class="article-body">{{ item.body }}</p>
        </article>
    </div>
</template>

<script>

import PopupMessage from "./ArticlePopup.vue";
import UpdateArticle from "../pages/UpdateArticle.vue";
import {mapGetters} from "vuex";

export default {
    name: "Home",
    components: {PopupMessage, UpdateArticle},
    props: {
        isDropPopupOpen: {
            "type": Boolean,
            "required": true,
        },
    },
    computed: {
        ...mapGetters('homeArticlesModule', ['getArticles',])
    },
}
</script>

<style scoped>
</style>
