import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);
import store from '../store';

import PostList from '../../components/PostList';
import PostView from '../../components/PostView';
import PostCreate from '../../components/PostCreate';
import PostEdit from "../../components/PostEdit";

let router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'posts',
            component: PostList
        },
        {
            path: '/create',
            name: 'create',
            component: PostCreate
        },
        {
            path: '/posts/:post',
            name: 'post',
            component: PostView
        },
        {
            path: '/posts/edit/:post',
            name: 'edit',
            component: PostEdit
        }
    ],
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});

export default router;
