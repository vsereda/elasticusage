const searchArticleModule = {
    namespaced: true,
    state() {
        return {
            articles: [],
            isArticlesDirty: false,
            isArticleLoading: false,
            resultsSearchString: '',
            meta: {},
            links: {},
            articleLoadingError: false,
            searchString: '',
            searchArticleURL: 'api/articles/search/',
        }
    },
    getters: {
        getArticles(state) {
            return state.articles
        },
        getSearchString(state) {
            return state.searchString
        },
        getSearchArticleURL(state) {
            return state.searchArticleURL
        },
        getIsArticleLoading(state) {
            return state.isArticleLoading
        },
        getLoadSearchResults(state) {
            return state.loadSearchResults
        },
        getResultsSearchString(state) {
            return state.resultsSearchString
        },
        getIsArticlesDirty(state) {
            return state.isArticlesDirty
        },
        getArticleLoadingError(state) {
            return state.articleLoadingError
        },
    },
    mutations: {
        setArticles(state, payload) {
            state.articles = payload
        },
        setIsArticleLoading(state, payload) {
            state.isArticleLoading = payload
        },
        setIsArticlesDirty(state, payload) {
            state.isArticlesDirty = payload
        },
        setResultsSearchString(state, payload) {
            state.resultsSearchString = payload
        },
        setMeta(state, payload) {
            state.meta = payload
        },
        setLinks(state, payload) {
            state.links = payload
        },
        setArticleLoadingError(state, payload) {
            state.articleLoadingError = payload
        },
        setSearchString(state, payload) {
            state.searchString = payload
        },
        setArticleIdForEdit(state, payload) {
            state.articleIdForEdit = payload
        },
    },
    actions: {
        loadSearchResults(context, v$) {
            context.dispatch('resetSearchResults')
            axios.post(context.getters.getSearchArticleURL, {
                search_phrase: context.getters.getSearchString,
            },).then((response) => {
                context.commit('setArticles', response?.data?.articles)
                context.commit('setMeta', response?.data?.meta)
                context.commit('setLinks', response?.data?.links)
            }).catch(() => {
                context.commit('setArticleLoadingError', true)
            }).finally(() => {
                context.dispatch('setAfterSearchLoading', v$)
            })
        },
        resetSearchResults(context) {
            context.commit('setArticles', [])
            context.commit('setIsArticleLoading', true)
            context.commit('setIsArticlesDirty', true)
            context.commit('setResultsSearchString', '')
        },
        setAfterSearchLoading(context, v$) {
            context.commit('setIsArticleLoading', false)
            context.commit('setResultsSearchString', context.getters.getSearchString)
            context.commit('setSearchString', '')
            v$.$reset()
        },
    },
}
export default searchArticleModule
