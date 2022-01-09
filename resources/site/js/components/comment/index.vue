<template>
    <section class="course-item-block comments">
        <div class="comments__heading">
            <h3 class="comments__title">
                Комментарии к курсу :
            </h3>
            <button class="btn comments__button" @click.prevent="addComment">
                Добавить комментарий
            </button>
        </div>
    </section>
</template>
<script>
    export default {
        methods: {
            addComment() {
                if(this.authCheck) {
                    this.$eventBus.$emit('review-submitted', productReview)
                } else {
                    this.$eventBus.$emit('show-auth-modal');
                }
            },
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

            }
        },
    }
</script>
