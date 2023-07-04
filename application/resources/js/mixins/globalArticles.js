const globalArticles = {
    methods: {
        // Reload articles on all pages
        reloadAllArticles(context) {
            context.dispatch('homeArticlesModule/loadCurrentArticles', null, {root: true})
            setTimeout(() => {
                // timeout needed for update search index
                context.dispatch('searchArticleModule/loadCurrentArticles', null, {root: true})
            }, 2000)
        }
    },
}

export default globalArticles
