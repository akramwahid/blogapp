<template>
    <div>
        <div class="hpanel">
            <div class="panel-heading hbuilt">
                Do you want to write a Comment?
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Message</label>
                            <textarea rows="3" class="form-control" v-model="comment.message"></textarea>
                        </div>

                        <div class="text-center m-t-md">
                            <button type="button" @click="addComment()" class="btn btn-primary"><i
                                class="fa fa-save"></i> ADD COMMENT
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hpanel forum-box">
            <div class="panel-heading hbuilt">
                <i class="fa fa-comments-o"> </i> {{ comments.length }} Comments
            </div>

            <div class="panel-body">
                <div class="chat-discussion" v-if="comments.length">
                    <div v-for="(comment, index) in comments" :key="index" class="chat-message left">
                        <i class="fa fa-user fa-3x"></i>
                        <div class="message">
                            <a class="message-author text-danger" href="javascript:void(0)"
                               @click="deleteComment(comment)">
                                Delete </a>
                            <span class="message-date">  {{ comment.created_at }} </span>
                            <span class="message-content" v-html="comment.message">

                                        </span>
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning text-center" v-else>
                    <i class="fa fa-smile-o"></i> Be the first one to write a comment :(
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";

    export default {
        name: 'CommentList',
        props: ['postId'],
        data() {
            return {
                comment: {
                    post_id: null,
                    message: ''
                },
            }
        },
        computed: {
            comments() {
                return this.$store.getters.getComments;
            }
        },
        methods: {
            async addComment() {
                $(".splash").show();

                try {
                    await this.$store.dispatch("addComment", this.comment);
                    $(".splash").hide();
                    this.comment.message = '';
                    toastr.success("Comment was added successfully.");
                } catch (error) {
                    $(".splash").hide();
                }
            },

            deleteComment(comment) {
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
                        vm.$store.dispatch("deleteComment", comment);
                        toastr.success("Comment deleted successfully");
                    }
                })
            }
        },

        async mounted() {
            this.$store.commit("resetStateComment");
            await this.$store.dispatch("fetchComments", this.postId);
            this.comment.post_id = this.postId;
        }
    }
</script>
