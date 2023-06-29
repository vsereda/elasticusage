import {createStore} from 'vuex';
import homeArticlesModule from './home';
import newArticleModule from './new';
import searchArticleModule from "./search";

const store = createStore({
    modules: {
        homeArticlesModule,
        newArticleModule,
        searchArticleModule,
    }
})

export default store
