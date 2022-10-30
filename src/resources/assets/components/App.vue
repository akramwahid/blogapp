<template>
    <div id="app">
        <div class="splash">
            <div class="color-line"></div>
            <div class="splash-title"><h1>Blog App</h1>
                <p> Loading.... </p>
                <div class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </div>
        </div>
        <div id="header">
            <div class="color-line">
            </div>
            <nav role="navigation">
                <router-link class="header-link" :to="{name: 'posts'}"><i class="fa fa-home"></i></router-link>
                <div class="small-logo">
                    <span class="text-primary">Homecarehub</span>
                </div>
            </nav>
        </div>

        <div id="wrapper">
            <router-view></router-view>

            <footer class="footer">Interview Technical Task
            </footer>
        </div>
    </div>
</template>

<script>
    import 'font-awesome/css/font-awesome.css';
    import 'toastr/build/toastr.css';
    import {HTTP} from '../js/utils/request';

    export default {
        name: 'App',
        data() {
            return {
                loading: false
            }
        },

        created() {
            const vm = this;

            HTTP.interceptors.response.use(response => response, error => {
                vm.handleError(error);
            });
        }
    }
</script>

<style src='../theme/styles/style.css'></style>
<style src='../theme/styles/custom.css'></style>
