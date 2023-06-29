import {createStore} from 'vuex';
import homeArticlesModule from './home';
import newArticleModule from './new'

const store = createStore({
    modules: {
        homeArticlesModule,
        newArticleModule,
    }
})

export default store
