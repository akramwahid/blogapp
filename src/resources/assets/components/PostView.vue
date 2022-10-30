<template>
    <div>
        <div class="small-header transition animated fadeIn">
            <div class="hpanel">
                <div class="panel-body">
                    <div class="row float-e-margins">
                        <div class="col-md-1">
                            <router-link :to="{name: 'posts'}" class="btn btn-primary btn-block">
                                <i class="fa fa-arrow-left"></i> BACK
                            </router-link>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 pull-right">
                            <router-link :to="{name: 'edit', params: {post: post.id }}"
                                         class="btn btn-primary btn-block">
                                <i class="fa fa-pencil"></i> EDIT
                            </router-link>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 pull-right">
                            <button type="button" @click="deletePost()" class="btn btn-block btn-danger2"><i
                                class="fa fa-trash-o"></i> DELETE POST
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content content-boxed">
            <div class="row">
                <div class="col-lg-12">
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

                    <div class="hpanel blog-article-box" v-if="!isLoading">
                        <div class="panel-heading">
                            <h4>{{ post.title }}</h4>
                            <div class="text-muted small" v-if="post.author">
                                <i class="fa fa-user"></i> Author: <span class="font-bold">{{ post.author.name }}</span>
                                <br>
                                <i class="fa fa-calendar-o"></i> {{ post.created_at }}
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="m-b-lg">
                                <img :src="post.image" class="img-responsive"/>
                            </div>
                            <p v-html="post.body_html"></p>
                        </div>
                    </div>

                    <CommentList :postId="$route.params.post" v-if="!isLoading"></CommentList>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {HTTP} from '../js/utils/request';
    import $ from "jquery";
    import CommentList from "./CommentList";

    export default {
        name: 'PostView',
        components: {
            CommentList
        },
        data() {
            return {
                isLoading: false
            }
        },
        computed: {
            post() {
                return this.$store.getters.getPost;
            }
        },
        methods: {
            deletePost() {
                const vm = this;

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to undo this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        vm.$store.dispatch("deletePost", this.$route.params.post);
                        vm.$router.push({name: 'posts'});
                        toastr.success("Post deleted successfully");
                    }
                })
            }
        },

        async created() {
            this.isLoading = true;
            await this.$store.dispatch("fetchPost", this.$route.params.post);
            this.isLoading = false;
        }
    }
</script>
