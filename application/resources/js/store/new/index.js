const newArticleModule = {
    namespaced: true,
    state() {
        return {
            isArticleUpdating: false,
            newArticle: {},
            isPopupUpdateOpen: false,
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
            return state.isPopupUpdateOpen
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
        SET_ARTICLE_UPDATING(state, payload) {
            state.isArticleUpdating = payload
        },
        SET_NEW_ARTICLE(state, payload) {
            state.newArticle = payload
        },
        SET_POPUP_UPDATE_OPEN(state, payload) {
            state.isPopupUpdateOpen = payload
        },
        SET_ARTICLE_DIRTY(state, payload) {
            state.isArticleDirty = payload
        },
        SET_ARTICLE(state, payload) {
            state.article = payload
        },
        SET_ARTICLE_UPDATE_ERROR(state, payload) {
            state.articleUpdateError = payload
        },
        SET_ARTICLE_ERROR_MESSAGE(state, payload) {
            state.articleErrorMessage = payload
        },
    },
    actions: {
        storeArticle(context, article) {
            context.commit('SET_ARTICLE_UPDATING', true)
            axios.post(context.getters.getCreateArticleURL, article).then(
                (response) => {
                    if (response.data?.article?.id > 0) {
                        context.commit('SET_NEW_ARTICLE', response.data.article)
                        context.commit('SET_POPUP_UPDATE_OPEN', true)
                        context.commit('SET_ARTICLE_DIRTY', false)
                        context.commit('SET_ARTICLE', {})
                    }
                    context.commit('SET_ARTICLE_UPDATE_ERROR', false)
                    context.dispatch('homeArticlesModule/loadCurrentArticles', null, {root: true})
                    setTimeout(() => {
                        // timeout needed for update search index
                        context.dispatch('searchArticleModule/loadCurrentArticles', null, {root: true})
                    }, 2000)
                }
            ).catch(() => {
                context.commit('SET_ARTICLE_ERROR_MESSAGE', 'Article create error')
                context.commit('SET_ARTICLE_UPDATE_ERROR', true)
            }).finally(() => {
                context.commit('SET_ARTICLE_UPDATING', false)
            })
        },
    },
}

export default newArticleModule
