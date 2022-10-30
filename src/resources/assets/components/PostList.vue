<template>
    <div>
        <div class="small-header transition animated fadeIn">
            <div class="hpanel">
                <div class="panel-body">
                    <div class="row float-e-margins">
                        <div class="col-md-2 hidden-xs">
                            <h2 class="font-light m-b-xs">
                                All Posts
                            </h2>
                            <small>Manage Posts</small>
                        </div>

                        <div class="col-md-2 pull-right">
                            <router-link :to="{name: 'create'}" class="btn btn-primary btn-block">
                                <i class="fa fa-plus"></i> NEW POST
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="content content-boxed">
            <section class="bg-light">
                <div class="containerd p-lg">
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="text" class="form-control input-lg" placeholder="Search By Author"
                                       v-model="searchAuthor" @input="isSearching = true">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="hpanel blog-box" v-for="(post, index) in posts" :key="index">

                                <div class="panel-heading">
                                    <div class="media clearfix">
                                        <a class="pull-left">
                                            <i class="fa fa-user fa-2x"></i>
                                        </a>
                                        <div class="media-body">
                                            <small>Author: <span class="font-bold">{{ post.author.name }}</span>
                                            </small>
                                            <br>
                                            <small class="text-muted">{{ post.created_at }}</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4 project-info">
                                            <router-link :to="{ name: 'post', params: { post: post.id } }">
                                                <img :src="post.image" class="img-responsive"/>
                                            </router-link>
                                        </div>

                                        <div class="col-md-8">
                                            <router-link :to="{ name: 'post', params: { post: post.id } }">
                                                <h4>{{ post.title }}</h4>
                                                <p>{{ post.body.substr(0,500) + '...' }}</p>
                                            </router-link>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-footer text-right">

                                    <router-link :to="{ name: 'post', params: { post: post.id } }">
                                        <h5>
                                            Read more
                                        </h5>
                                    </router-link>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <infinite-loading @infinite="infiniteHandler" :distance="distance" ref="infiniteLoading">
                                <div slot="spinner"></div>
                                <div slot="no-results" class="m-t-lg">
                                    <p class="alert alert-warning">
                                        No records found.
                                    </p>
                                </div>
                                <div slot="no-more" class="m-t-xs m-b-xs">
                                    <p class="text-info">
                                        There is no more records found :(
                                    </p>
                                </div>
                            </infinite-loading>

                            <div v-if="isLoading">
                                <div class="timeline-item">
                                    <div class="animated-background">
                                        <div class="background-masker header-top"></div>
                                        <div class="background-masker header-left"></div>
                                        <div class="background-masker header-right"></div>
                                        <div class="background-masker header-bottom"></div>
                                        <div class="background-masker subheader-left"></div>
                                        <div class="background-masker subheader-right"></div>
                                        <div class="background-masker subheader-bottom"></div>
                                        <div class="background-masker content-top"></div>
                                        <div class="background-masker content-second-line"></div>
                                        <div class="background-masker content-third-line"></div>
                                        <div class="background-masker content-third-end"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </section>

        </div>
    </div>
</template>
<script>
    import InfiniteLoading from 'vue-infinite-loading';
    import {HTTP} from '../js/utils/request';
    import * as _ from 'lodash';

    export default {
        name: 'PostList',
        components: {
            InfiniteLoading
        },
        data() {
            return {
                distance: 100,
                isLoading: false,
                page: 1,
                searchAuthor: '',
                isSearching: false
            }
        },
        computed: {
            posts() {
                return this.$store.getters.getPosts
            }
        },
        watch: {
            searchAuthor: _.debounce(function () {
                this.isSearching = false;
            }, 200),

            isSearching: function (value) {
                if (!value) {
                    this.filterItems();
                }
            }
        },

        methods: {
            infiniteHandler($state) {
                this.isLoading = true;
                HTTP.get('/api/posts', {
                    params: {
                        page: this.page,
                        searchAuthor: this.searchAuthor
                    },
                }).then(response => {
                    this.isLoading = false;
                    if (response.data.data.length) {
                        this.page += 1;
                        this.$store.dispatch("fetchPosts", response.data.data);
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                }).catch(error => {
                    this.isLoading = false;
                    console.log(error);
                });
            },

            filterItems: function () {
                if (!this.isLoading) {
                    this.page = 1;
                    this.$store.commit("resetState");
                    this.$nextTick(function () {
                        this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');
                    });
                }
            },
        },

        created() {
            this.$store.commit("resetState");
        }
    }
</script>
