<template>
    <section class="course-item-block comments">
        <div class="comments__heading">
            <h3 class="comments__title">
                Комментарии к курсу:
            </h3>
            <button class="btn comments__button" @click.prevent="addComment">
                Добавить комментарий
            </button>
        </div>
        <list
            :course_id="course_id"
            v-on:answer-comment="commentAnswer"
            :auth="auth"
            @show-auth-modal="addComment" v-on:comments-count="" ref="list"></list>
        <el-dialog
            :visible.sync="commentModal"
            >
            <comment-form
                :user="user"
                :parent_id="parent_id"
                :course_id="course_id"
                v-on:close="closeModal()"
                v-on:store-comment="$emit('store-comment')"
            ></comment-form>

        </el-dialog>
    </section>
</template>
<script>
import list from './components/list';
import CommentForm from "./components/comment-form";
import EventBus from "../../EventBus";
export default {
        components: {
            CommentForm, list
        },
        props:{
            course_id:{
                type:Number,
                required:true,
            },
            show_comment: {
                type:String,
                required:true,
            }
        },
    data() {
            return {
                commentModal: false,
                parent_id:0,
                auth:false,
            }
    },
        methods: {
            commentAnswer() {

            },
            addComment() {
                if(this.authCheck) {
                    this.commentModal = true;
                } else {
                    EventBus.$emit('show-auth-modal', window.location.href);
                }
            },
            closeModal() {
                this.commentModal = false;
            }
        },
        computed: {
            signedIn() {
                return window.App.signedIn;
            },
            user(){
                return  window.App.user;
            },
            authCheck() {
                if(this.signedIn) {
                    return (this.user.profile_type === 'teacher') || (this.user.profile_type === 'student')
                } else {
                    return false;
                }
            },
        },
        mounted() {
            this.auth = this.authCheck
        }
}
</script>
