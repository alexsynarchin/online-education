<template>
    <a href="" class="course-item__btn btn" @click.prevent="buy">Купить</a>
</template>
<script>
import EventBus from "../../EventBus";

export default {
    methods: {
        buy() {
            if(this.authCheck) {

            } else {
                EventBus.$emit('show-auth-modal', window.location.href);
            }
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
}
</script>
