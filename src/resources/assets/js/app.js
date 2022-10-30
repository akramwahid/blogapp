import Vue from 'vue';
import App from '../components/App.vue';
import router from './router';
import store from './store';
import ValidationErrorHandler from "../js/utils/validationHandling";

window._ = require('lodash');
window.toastr = require('toastr');
window.Swal = require('sweetalert2');



Vue.mixin(ValidationErrorHandler);

Vue.mixin({
    methods: {
        handleError(error) {
            var message = '<ul>';
            if (typeof error !== 'undefined') {
                if (error.hasOwnProperty('message')) {
                    message += '<li>' + error.message + '</li>';
                }
            }
            if (typeof error.response !== 'undefined') {
                //Setup Generic Response Messages
                if (error.response.status === 401) {
                    message += '<li>UnAuthorized</li>';
                } else if (error.response.status === 404) {
                    message += '<li>API Route is Missing or Undefined</li>';
                } else if (error.response.status === 405) {
                    message += '<li>API Route Method Not Allowed</li>';
                } else if (error.response.status === 422) {
                    //Validation Message
                } else if (error.response.status >= 500) {
                    message += '<li>Server Error</li>';
                }

                if (error.hasOwnProperty('response') && error.response.hasOwnProperty('data')) {
                    if (error.response.data.hasOwnProperty('message') && error.response.data.message.length > 0) {
                        message += '<li>' + error.response.data.message + '</li>';
                    }
                }

                this.clearErrors();
                this.syncErrors(error);

                if (this.hasErrors('image')) {
                    message += '<li>' + this.getError('image') + '</li>';
                }
                if (this.hasErrors('title')) {
                    message += '<li>' + this.getError('title') + '</li>';
                }
                if (this.hasErrors('body')) {
                    message += '<li>' + this.getError('body') + '</li>';
                }
                if (this.hasErrors('author_id')) {
                    message += '<li>' + this.getError('author_id') + '</li>';
                }
            }

            toastr.error(message);
        }

    }
});

var app = new Vue({
    el: '#app',
    render: h => h(App),
    router,
    store
});
