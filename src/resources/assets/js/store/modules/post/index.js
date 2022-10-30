import {HTTP} from '../../../utils/request';

let state = {
    posts: [],
    post: {}
};

let getters = {
    getPosts(state) {
        return state.posts;
    },
    getPost(state) {
        return state.post;
    }
};

let mutations = {
    setPosts(state, items) {
        state.posts.push(...items);
    },
    resetState(state) {
        state.posts = [];
        state.post = {};
    },
    setPost(state, post) {
        state.post = post;
    }
};

let actions = {
    fetchPosts({commit}, items) {
        commit('setPosts', items);
    },

    fetchPost({commit, state}, id) {
        return new Promise((resolve, reject) => {
            HTTP.get('/api/posts/' + id)
                .then(response => {
                    commit("setPost", response.data.data);
                    resolve();
                }).catch(error => {
                reject(new Error(error.response.statusText));
            });
        });
    },

    addPost({commit, state}, post) {
        return new Promise((resolve, reject) => {
            HTTP.post('/api/posts', {
                title: post.title,
                body: post.body,
                image: post.image,
                author_id: post.author.id
            }).then(response => {
                commit("setPost", response.data.data);
                resolve();
            }).catch(error => {
                reject();
            })
        });
    },
    updatePost({commit, state}, post) {
        return new Promise((resolve, reject) => {
            HTTP.put('/api/posts/' + post.id, {
                title: post.title,
                body: post.body,
                image: post.image,
                author_id: post.author.id
            }).then(response => {
                commit("setPost", response.data.data);
                resolve();
            }).catch(error => {
                reject();
            })
        });
    },

    deletePost({commit, state}, id) {
        return new Promise((resolve, reject) => {
            HTTP.delete('/api/posts/' + id).then(response => {
                resolve();
            }).catch(error => {
                reject();
            })
        });
    }
};

export default {
    state,
    getters,
    mutations,
    actions
}
