import {HTTP} from "../../../utils/request";

let state = {
    comments: [],
    comment: {}
};

let getters = {
    getComments(state) {
        return state.comments;
    },

    getComment(state) {
        return state.comment;
    }
};

let mutations = {
    setComments(state, items) {
        state.comments.push(...items);
    },

    resetStateComment(state) {
        state.comments = [];
        state.comment = {};
    },

    setComment(state, comment) {
        state.comment = comment;
    }
};

let actions = {
    fetchComments({commit}, post) {
        return new Promise((resolve, reject) => {
            HTTP.get('/api/posts/' + post + '/comments')
                .then(response => {
                    commit("setComments", response.data.data);
                    resolve();
                }).catch(error => {
                reject();
            });
        });
    },

    addComment({commit, dispatch}, comment) {
        return new Promise((resolve, reject) => {
            HTTP.post('/api/posts/' + comment.post_id + '/comments', {
                message: comment.message,
                post_id: comment.post_id
            }).then(response => {
                commit("resetStateComment");
                dispatch("fetchComments", comment.post_id);
                commit("setComment", response.data.data);
                resolve();
            }).catch(error => {
                reject();
            });
        });
    },

    deleteComment({commit, dispatch}, comment) {
        return new Promise((resolve, reject) => {
            HTTP.delete('/api/comments/' + comment.id).then(response => {
                commit("resetStateComment");
                dispatch("fetchComments", comment.post_id);
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
