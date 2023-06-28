import {createStore} from 'vuex';
import articlesModule from './home';
import newArticleModule from './new'

const store = createStore({
    modules: {
        homeArticlesModule: articlesModule,
        newArticleModule: newArticleModule,
    }
})

export default store
