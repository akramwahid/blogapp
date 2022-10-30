<template>
    <div>
        <div class="small-header transition animated fadeIn">
            <div class="hpanel">
                <div class="panel-body">
                    <div class="row float-e-margins">
                        <div class="col-md-1 hidden-xs">
                            <h2 class="font-light m-b-xs">
                                CREATE POST
                            </h2>
                            <small>Manage Posts</small>
                        </div>

                        <div class="col-md-1">
                            <router-link :to="{name: 'posts'}" class="btn btn-primary btn-block">
                                <i class="fa fa-arrow-left"></i> BACK
                            </router-link>
                        </div>

                        <div class="col-md-2 pull-right">
                            <button type="button" @click="savePost()" class="btn btn-primary btn-block"><i
                                class="fa fa-save"></i> SAVE POST
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="login-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center m-b-md">
                            <h3 class="text-primary"><i class="fa fa-pencil-square-o fa-3x"></i></h3>
                        </div>

                        <div class="hpanel">
                            <div class="panel-body">
                                <input type="file" style="display: none;" name="fileupload-picture"
                                       id="fileupload-picture">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="display: none" id="progress"
                                                 class="progress m-t-xs full progress-striped active">
                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>

                                            <div class="row" v-show="post.image == ''">
                                                <a v-on:click="uploadImage()">
                                                    <div class="col-md-12" style="">
                                                        <div class="hpanel hgreen">
                                                            <div class="panel-body file-body ">
                                                                <i class="fa fa-cloud-upload text-success"></i>
                                                            </div>
                                                            <div class="panel-footer text-center">
                                                                <span style="font-size: 14px;">Drag & drop or click here and upload Cover Image.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="row" v-if="post.image">
                                                <div class="col-md-12 text-center">
                                                    <span class="pull-right">
                                                       <a href="javascript:void(0);" @click="post.image = ''"
                                                          class="text-danger"> <i class="fa fa-trash-o"> </i> Delete</a>
                                                    </span>
                                                    <img class="img-responsive" v-bind:src="post.image"
                                                         style="display: block;margin: 0 auto;height: 300px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Select or Add Author</label>
                                    <multiselect v-model="post.author" open-direction="bottom" :options="authors"
                                                 :loading="isLoading" :taggable="true"
                                                 tag-placeholder="Add this as a new author" @tag="addAuthor"
                                                 placeholder="Select Author" label="name" track-by="id">
                                    </multiselect>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Title</label>
                                    <input type="text" v-model="post.title" class="form-control input-lg">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Body</label>
                                    <textarea rows="12" class="form-control" v-model="post.body"></textarea>
                                </div>


                                <div class="text-center m-t-lg">
                                    <button type="button" @click="savePost()" class="btn btn-primary px-20"><i
                                        class="fa fa-save"></i> SAVE POST
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import $ from 'jquery';
    import 'blueimp-file-upload/js/jquery.fileupload.js';
    import Multiselect from 'vue-multiselect';

    export default {
        name: 'PostCreate',
        components: {
            Multiselect
        },
        data() {
            return {
                post: {
                    title: '',
                    body: '',
                    image: '',
                    author: '',
                },
                isLoading: false,
                showLoader: false
            }
        },
        computed: {
            authors() {
                return this.$store.getters.getAuthors;
            }
        },
        methods: {
            uploadImage() {
                $("#progress .progress-bar").css("width", "0%");
                $("#fileupload-picture").trigger("click");
            },

            async addAuthor(newAuthor) {
                this.isLoading = true;
                await this.$store.dispatch("addAuthor", newAuthor);
                this.post.author = this.$store.getters.getAuthor;
                this.isLoading = false;
            },

            async savePost() {
                $(".splash").show();

                try {
                    await this.$store.dispatch("addPost", this.post);
                    $(".splash").hide();
                    this.$router.push({name: 'post', params: {post: this.$store.getters.getPost.id}});
                    toastr.success("Post created successfully");
                } catch (error) {
                    $(".splash").hide();
                    //this.handleError(error);
                }
            },
        },
        mounted() {
            var self = this;

            $("#fileupload-picture").fileupload({
                type: 'POST',
                dataType: "json",
                url: "/api/posts/image/upload",
                autoUpload: true,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                },
                start: function () {
                    $("#progress").show();
                },
                stop: function () {
                    $("#progress").hide();
                },
                progressall: function (n, t) {
                    var i = parseInt(t.loaded / t.total * 100, 10);
                    $("#progress .progress-bar").css("width", i + "%");
                    $("#progress .progress-bar").attr("aria-valuenow", i);
                    $("#progress .progress-bar").text(i + "%");
                },
                done: function (n, t) {
                    if (t.result.Status == "Fail") {
                        toastr.error(t.result.Message);
                    } else {
                        var i = t.result;
                        self.post.image = i.UrlPath;
                    }
                },
                fail: function (e, data) {
                    $("#progress").hide();
                    toastr.error(data.errorThrown);
                }
            });
        },
        created() {
            this.$store.commit("resetStateAuthor");
            this.$store.dispatch("fetchAuthors");
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
