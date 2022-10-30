import Vue from 'vue';
import Vuex from 'vuex';

import authorModule from './modules/author/index';
import postModule from './modules/post/index';
import commentModule from './modules/comment/index';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        authorModule,
        postModule,
        commentModule
    },
    state:{},
    mutations:{},
    getters:{},
    actions:{}
});
