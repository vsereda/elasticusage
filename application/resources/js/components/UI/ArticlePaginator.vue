<template>
    <nav class="articles-list-paginator" v-show="showPaginator">
        <div>
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
        </div>
        <p v-show="currentPage && lastPage">page {{ currentPage }} from {{ lastPage }}</p>
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
        currentPage: {
            type: Number,
            default: null
        },
        lastPage: {
            type: Number,
            default: null,
        },
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
