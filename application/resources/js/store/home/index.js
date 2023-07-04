const homeArticlesModule = {
    namespaced: true,
    state() {
        return {
            loadArticlesURL: '/api/articles',
            articles: [],
            meta: {},
            links: {},
            articleLoadingError: false,
            isArticlesDirty: false,
            isArticleLoading: false,
            currentPageUrl: '/api/articles',
        }
    },
    getters: {
        getArticles(state) {
            return state.articles
        },
        getArticlesLoadingError(state) {
            return state.articleLoadingError
        },
        getMeta(state) {
            return state.meta
        },
        getLinks(state) {
            return state.links
        },
        getIsArticlesDirty(state) {
            return state.isArticlesDirty
        },
        getIsArticleLoading(state) {
            return state.isArticleLoading
        },
        getFirstPageActive(state) {
            return (state.meta?.current_page > 1) && (state.articles.length !== 0);
        },
        getPrevPageActive(state) {
            return (state.links?.prev !== null) && (state.articles.length !== 0)
        },
        getNextPageActive(state) {
            return (state.links?.next !== null) && (state.articles.length !== 0)
        },
        getLastPageActive(state) {
            return (state.links?.next !== null) && (state.articles.length !== 0)
        },
        getNoArticles(state) {
            return (state.articles.length === 0) && !state.articleLoadingError && state.isArticlesDirty
        },
        getArticleLoadingError(state) {
            return state.isArticlesDirty && state.articleLoadingError
        },
        getCurrentPageUrl(state) {
            return state.currentPageUrl
        },
        getLoadArticlesURL(state) {
            return state.loadArticlesURL
        },
    },
    mutations: {
        SET_ARTICLES(state, payload) {
            state.articles = payload
        },
        SET_ARTICLE_LOADING_ERROR(state, payload) {
            state.articleLoadingError = payload
        },
        SET_META(state, payload) {
            state.meta = payload
        },
        SET_LINKS(state, payload) {
            state.links = payload
        },
        SET_IS_ARTICLE_DIRTY(state, payload) {
            state.isArticlesDirty = payload
        },
        SET_IS_ARTICLE_LOADING(state, payload) {
            state.isArticleLoading = payload
        },
        SET_CURRENT_PAGE_URL(state, payload) {
            state.currentPageUrl = payload
        },
    },
    actions: {
        loadArticles(context, url) {
            context.commit('SET_CURRENT_PAGE_URL', url)
            context.commit('SET_IS_ARTICLE_LOADING', true)
            context.commit('SET_IS_ARTICLE_DIRTY', true)

            axios.get(url).then((response) => {
                context.commit('SET_LINKS', response?.data?.links)
                context.commit('SET_META', response?.data?.meta)
                if (response?.data?.data?.length > 0) {
                    context.commit('SET_ARTICLES', response.data.data)
                }
            }).catch(() => {
                context.commit('SET_ARTICLE_LOADING_ERROR', true)
            }).finally(() => {
                context.commit('SET_IS_ARTICLE_LOADING', false)
            });
        },
        loadCurrentArticles(context) {
            context.dispatch('loadArticles', context.state.currentPageUrl)
        },
        loadFirstArticles(context) {
            context.dispatch('loadArticles', context.state.links?.first)
        },
        loadPreviousArticles(context) {
            context.dispatch('loadArticles', context.state.links?.prev)
        },
        loadNextArticles(context) {
            context.dispatch('loadArticles', context.state.links?.next)
        },
        loadLastArticles(context) {
            context.dispatch('loadArticles', context.state.links?.last)
        },
    },
}

export default homeArticlesModule
