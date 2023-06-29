<template>
    <nav class="articles-list-paginator" v-show="showPaginator">
        <button
            @click="this.$emit('loadFirstArticles')"
            :disabled="!firstPageActive"
        >
            first
        </button>
        <button
            @click="this.$emit('loadPreviousArticles')"
            :disabled="!prevPageActive"
        >
            previous
        </button>
        <button
            @click="this.$emit('loadNextArticles')"
            :disabled="!nextPageActive"
        >
            next
        </button>
        <button
            @click="this.$emit('loadLastArticles')"
            :disabled="!lastPageActive"
        >
            last
        </button>
    </nav>
</template>

<script>
export default {
    name: "ArticlePaginator",
    data: function () {
        return {
            a: {},
        }
    },
    props: {
        firstPageActive: {
            type: Boolean,
            required: true,
        },
        prevPageActive: {
            type: Boolean,
            required: true,
        },
        nextPageActive: {
            type: Boolean,
            required: true,
        },
        lastPageActive: {
            type: Boolean,
            required: true,
        },
        showPaginator: {
            type: Boolean,
            default: true,
        },
    }
}
</script>

<style scoped>
</style>
