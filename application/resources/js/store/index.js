import {createStore} from 'vuex';
import articlesModule from './home/articles';

const store = createStore({
    modules: {
        homeArticlesModule: articlesModule,
    }
})

export default store
