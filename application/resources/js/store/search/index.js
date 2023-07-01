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
            currentPageUrl: 'api/articles/search/',
        }
    },
    getters: {
        getArticles(state) {
            return state.articles
        },
        getSearchString(state) {
            return state.searchString
        },
        getIsArticleLoading(state) {
            return state.isArticleLoading
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
        getLinks(state) {
            return state.links
        },
        getCurrentPageUrl(state) {
            return state.currentPageUrl
        },
        getSearchArticleURL(state) {
            return state.searchArticleURL
        },
        getMeta(state) {
            return state.meta
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
        setCurrentPageUrl(state, payload) {
            state.currentPageUrl = payload
        },
    },
    actions: {
        loadSearchResults(context, payload) {
            if (payload?.reset) {
                context.dispatch('resetSearchResults')
            }
            context.commit('setCurrentPageUrl', payload.url)
            axios.post(payload.url, {
                search_phrase: payload.searchStr,
            },).then((response) => {
                context.commit('setArticles', response?.data?.articles)
                context.commit('setMeta', response?.data?.meta)
                context.commit('setLinks', response?.data?.links)
            }).catch(() => {
                context.commit('setArticleLoadingError', true)
            }).finally(() => {
                context.dispatch('setAfterSearchLoading')
            })
        },
        resetSearchResults(context) {
            context.commit('setArticles', [])
            context.commit('setIsArticleLoading', true)
            context.commit('setIsArticlesDirty', true)
        },
        setAfterSearchLoading(context) {
            context.commit('setIsArticleLoading', false)
            if (context.getters.getSearchString) {
                context.commit('setResultsSearchString', context.getters.getSearchString)
            }
            context.commit('setSearchString', '')
        },
        loadCurrentArticles(context) {
            let searchStr = context.getters.getResultsSearchString
            if (searchStr !== '') {
                context.dispatch('loadSearchResults', {
                    url: context.getters.getCurrentPageUrl,
                    searchStr: searchStr,
                })
            }
        },
        loadFirstArticles(context) {
            context.dispatch('loadSearchResults', {
                url: context.getters.getLinks?.first,
                searchStr: context.getters.getResultsSearchString
            })
        },
        loadPreviousArticles(context) {
            context.dispatch('loadSearchResults', {
                url: context.getters.getLinks?.prev,
                searchStr: context.getters.getResultsSearchString
            })
        },
        loadNextArticles(context) {
            context.dispatch('loadSearchResults', {
                url: context.getters.getLinks?.next,
                searchStr: context.getters.getResultsSearchString
            })
        },
        loadLastArticles(context) {
            context.dispatch('loadSearchResults', {
                url: context.getters.getLinks?.last,
                searchStr: context.getters.getResultsSearchString
            })
        },
    },
}
export default searchArticleModule
