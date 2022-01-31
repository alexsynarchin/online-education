<template>
    <a href="" class="course-item__btn btn" @click.prevent="buy">Купить</a>
</template>
<script>
import EventBus from "../../EventBus";

export default {
    props: {
        buying_type:{
            default: 'course',
        },
        buying_id: {
            type:Number,
        }
    },
    methods: {
        buy() {
            if(this.authCheck) {
                EventBus.$emit('show-buy-modal', {id:this.buying_id, type:this.buying_type});
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
                return this.user.profile_type === 'student';
            } else {
                return false;
            }
        },
    },
}
</script>
