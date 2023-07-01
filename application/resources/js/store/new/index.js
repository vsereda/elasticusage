const newArticleModule = {
    namespaced: true,
    state() {
        return {
            isArticleUpdating: false,
            newArticle: {},
            isPopupUpdatedOpen: false,
            isArticleDirty: false,
            article: {},
            articleUpdateError: false,
            articleErrorMessage: '',
            createArticleURL: '/api/articles',
        }
    },
    getters: {
        getIsArticleUpdating(state) {
            return state.isArticleUpdating
        },
        getIsArticleDirty(state) {
            return state.isArticleDirty
        },
        getNewArticle(state) {
            return state.newArticle
        },
        getIsPopupUpdatedOpen(state) {
            return state.isPopupUpdatedOpen
        },
        getArticle(state) {
            return state.article
        },
        getArticleUpdateError(state) {
            return state.articleUpdateError
        },
        getArticleErrorMessage(state) {
            return state.articleErrorMessage
        },
        getCreateArticleURL(state) {
            return state.createArticleURL
        }
    },
    mutations: {
        setIsArticleUpdating(state, payload) {
            state.isArticleUpdating = payload
        },
        setNewArticle(state, payload) {
            state.newArticle = payload
        },
        setIsPopupUpdatedOpen(state, payload) {
            state.isPopupUpdatedOpen = payload
        },
        setIsArticleDirty(state, payload) {
            state.isArticleDirty = payload
        },
        setArticle(state, payload) {
            state.article = payload
        },
        setArticleUpdateError(state, payload) {
            state.articleUpdateError = payload
        },
        setArticleErrorMessage(state, payload) {
            state.articleErrorMessage = payload
        },
    },
    actions: {
        storeArticle(context, article) {
            context.commit('setIsArticleUpdating', true)
            axios.post(context.getters.getCreateArticleURL, article).then(
                (response) => {
                    if (response.data?.article?.id > 0) {
                        context.commit('setNewArticle', response.data.article)
                        context.commit('setIsPopupUpdatedOpen', true)
                        context.commit('setIsArticleDirty', false)
                        context.commit('setArticle', {})
                    }
                    context.commit('setArticleUpdateError', false)
                    context.dispatch('homeArticlesModule/loadCurrentArticles', null, {root: true})
                    setTimeout(() => {
                        // timeout needed for update search index
                        context.dispatch('searchArticleModule/loadCurrentArticles', null, {root: true})
                    }, 2000)
                }
            ).catch(() => {
                context.commit('setArticleErrorMessage', 'Article create error')
                context.commit('setArticleUpdateError', true)
            }).finally(() => {
                context.commit('setIsArticleUpdating', false)
            })
        },
    },
}

export default newArticleModule
