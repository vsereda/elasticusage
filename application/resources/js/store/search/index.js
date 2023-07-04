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
        GET_ARTICLES(state) {
            return state.articles
        },
        GET_SEARCH_STRING(state) {
            return state.searchString
        },
        GET_ARTICLE_LOADING(state) {
            return state.isArticleLoading
        },
        GET_RESULT_SEARCH_STRING(state) {
            return state.resultsSearchString
        },
        GET_ARTICLE_DIRTY(state) {
            return state.isArticlesDirty
        },
        GET_ARTICLE_LOADING_ERROR(state) {
            return state.articleLoadingError
        },
        GET_LINKS(state) {
            return state.links
        },
        getCurrentPageUrl(state) {
            return state.currentPageUrl
        },
        GET_SEARCH_ARTICLE_URL(state) {
            return state.searchArticleURL
        },
        GET_META(state) {
            return state.meta
        },
        GET_FIRST_PAGE_ACTIVE(state) {
            return (state.meta?.current_page > 1) && (state.articles.length !== 0);
        },
        GET_PREV_PAGE_ACTIVE(state) {
            return (state.links?.prev !== null) && (state.articles.length !== 0)
        },
        GET_NEXT_PAGE_ACTIVE(state) {
            return (state.links?.next !== null) && (state.articles.length !== 0)
        },
        GET_LAST_PAGE_ACTIVE(state) {
            return (state.links?.next !== null) && (state.articles.length !== 0)
        },
    },
    mutations: {
        SET_ARTICLES(state, payload) {
            state.articles = payload
        },
        SET_ARTICLES_LOADING(state, payload) {
            state.isArticleLoading = payload
        },
        SET_ARTICLES_DIRTY(state, payload) {
            state.isArticlesDirty = payload
        },
        SET_ARTICLES_SEARCH_STRING(state, payload) {
            state.resultsSearchString = payload
        },
        SET_META(state, payload) {
            state.meta = payload
        },
        SET_LINKS(state, payload) {
            state.links = payload
        },
        SET_ARTICLE_LOADING(state, payload) {
            state.articleLoadingError = payload
        },
        SET_SEARCH_STRING(state, payload) {
            state.searchString = payload
        },
        SET_CURRENT_PAGE_URL(state, payload) {
            state.currentPageUrl = payload
        },
    },
    actions: {
        loadSearchResults(context, payload) {
            if (payload?.reset) {
                context.dispatch('resetSearchResults')
            }
            context.commit('SET_CURRENT_PAGE_URL', payload.url)
            axios.post(payload.url, {
                search_phrase: payload.searchStr,
            },).then((response) => {
                context.commit('SET_ARTICLES', response?.data?.articles)
                context.commit('SET_META', response?.data?.meta)
                context.commit('SET_LINKS', response?.data?.links)
            }).catch(() => {
                context.commit('SET_ARTICLE_LOADING', true)
            }).finally(() => {
                context.dispatch('setAfterSearchLoading')
            })
        },
        resetSearchResults(context) {
            context.commit('SET_ARTICLES', [])
            context.commit('SET_ARTICLES_LOADING', true)
            context.commit('SET_ARTICLES_DIRTY', true)
        },
        setAfterSearchLoading(context) {
            context.commit('SET_ARTICLES_LOADING', false)
            if (context.state.searchString) {
                context.commit('SET_ARTICLES_SEARCH_STRING', context.state.searchString)
            }
            context.commit('SET_SEARCH_STRING', '')
        },
        loadCurrentArticles(context) {
            const searchStr = context.state.resultsSearchString
            if (searchStr !== '') {
                context.dispatch('loadSearchResults', {
                    url: context.state.currentPageUrl,
                    searchStr: searchStr,
                })
            }
        },
        loadFirstArticles(context) {
            context.dispatch('loadSearchResults', {
                url: context.state.links?.first,
                searchStr: context.state.resultsSearchString
            })
        },
        loadPreviousArticles(context) {
            context.dispatch('loadSearchResults', {
                url: context.state.links?.prev,
                searchStr: context.state.resultsSearchString
            })
        },
        loadNextArticles(context) {
            context.dispatch('loadSearchResults', {
                url: context.state.links?.next,
                searchStr: context.state.resultsSearchString
            })
        },
        loadLastArticles(context) {
            context.dispatch('loadSearchResults', {
                url: context.state.links?.last,
                searchStr: context.state.resultsSearchString
            })
        },
    },
}
export default searchArticleModule
