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
            popupMessage: '',
            dropArticleURL: '/api/articles',
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
        firstPageActive(state) {
            return (state.meta?.current_page > 1) && (state.articles.length !== 0);
        },
        prevPageActive(state) {
            return (state.links?.prev !== null) && (state.articles.length !== 0)
        },
        nextPageActive(state) {
            return (state.links?.next !== null) && (state.articles.length !== 0)
        },
        lastPageActive(state) {
            return (state.links?.next !== null) && (state.articles.length !== 0)
        },
        noArticles(state) {
            return (state.articles.length === 0) && !state.articleLoadingError && state.isArticlesDirty
        },
        showArticleLoadingError(state) {
            return state.isArticlesDirty && state.articleLoadingError
        },
        getCurrentPageUrl(state) {
            return state.currentPageUrl
        },
        getPopupMessage(state) {
            return state.popupMessage
        },
        getLoadArticlesURL(state) {
            return state.loadArticlesURL
        },
        getDropArticleURL(state) {
            return state.dropArticleURL
        }
    },
    mutations: {
        setArticles(state, payload) {
            state.articles = payload
        },
        setArticleLoadingError(state, payload) {
            state.articleLoadingError = payload
        },
        setMeta(state, payload) {
            state.meta = payload
        },
        setLinks(state, payload) {
            state.links = payload
        },
        setIsArticlesDirty(state, payload) {
            state.isArticlesDirty = payload
        },
        setIsArticleLoading(state, payload) {
            state.isArticleLoading = payload
        },
        setCurrentPageUrl(state, payload) {
            state.currentPageUrl = payload
        },
        setPopupMessage(state, payload) {
            state.popupMessage = payload
        },
    },
    actions: {
        dropArticle(context, id) {
            axios.delete(context.getters.getDropArticleURL.concat('/', id)).then(
                (response) => {
                    if (response?.data?.article?.id > 0) {
                        context.dispatch('loadCurrentArticles')
                        context.commit('setPopupMessage', 'Article '.concat(response.data.article.id, ' successfully deleted!'))
                    }
                }
            ).catch(
                context.commit('setPopupMessage', 'Drop article error!')
            )
        },
        loadArticles(context, url) {
            context.commit('setCurrentPageUrl', url)
            context.commit('setIsArticleLoading', true)
            context.commit('setIsArticlesDirty', true)

            axios.get(url).then((response) => {
                context.commit('setLinks', response?.data?.links)
                context.commit('setMeta', response?.data?.meta)
                if (response?.data?.data?.length > 0) {
                    context.commit('setArticles', response.data.data)
                }
            }).catch(() => {
                context.commit('setArticleLoadingError', true)
            }).finally(() => {
                context.commit('setIsArticleLoading', false)
            });
        },
        loadCurrentArticles(context) {
            context.dispatch('loadArticles', context.getters.getCurrentPageUrl)
        },
        loadFirstArticles(context) {
            context.dispatch('loadArticles', context.getters.getLinks?.first)
        },
        loadPreviousArticles(context) {
            context.dispatch('loadArticles', context.getters.getLinks?.prev)
        },
        loadNextArticles(context) {
            context.dispatch('loadArticles', context.getters.getLinks?.next)
        },
        loadLastArticles(context) {
            context.dispatch('loadArticles', context.getters.getLinks?.last)
        },
    },
}

export default homeArticlesModule
