import {HTTP} from "../../../utils/request";

let state = {
    authors: [],
    author: {}
};

let getters = {
    getAuthors(state) {
        return state.authors;
    },

    getAuthor(state) {
        return state.author;
    }
};

let mutations = {
    setAuthors(state, items) {
        state.authors.push(...items);
    },
    resetStateAuthor(state) {
        state.authors = [];
        state.author = {};
    },
    setAuthor(state, author) {
        state.author = author;
    }
};

let actions = {
    fetchAuthors({commit}) {
        return new Promise((resolve, reject) => {
            HTTP.get('/api/authors')
                .then(response => {
                    commit("setAuthors", response.data.data);
                    resolve();
                }).catch(error => {
                reject(new Error(error.response.statusText));
            });
        });
    },

    fetchAuthor({commit, state}, id) {
        return new Promise((resolve, reject) => {
            HTTP.get('/api/authors/' + id)
                .then(response => {
                    commit("setAuthor", response.data.data);
                    resolve();
                }).catch(error => {
                reject(new Error(error.response.statusText));
            });
        });
    },

    addAuthor({commit, dispatch}, author) {
        return new Promise((resolve, reject) => {
            HTTP.post('/api/authors', {
                name: author
            }).then(response => {
                commit("resetStateAuthor");
                dispatch("fetchAuthors");
                commit("setAuthor", response.data.data);
                resolve();
            }).catch(error => {
                reject(new Error(error.response.statusText));
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
