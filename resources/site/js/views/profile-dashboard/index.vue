<template>
    <div class="b-profile-user">
        <div class="container">
            <div class="row">
                <ProfileSidebar :user="user" v-if="showSidebar"></ProfileSidebar>
                <div class="col-12"  :class="{
                    'col-sm-12 col-md-12 col-lg-9':showSidebar
                }" >
                    <router-view :user="user"></router-view>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import ProfileSidebar from "./ProfileSidebar";
    export default {
        components:{
            ProfileSidebar
        },
        computed: {
            showSidebar() {
                if((this.$route.name === 'lesson.create') || (this.$route.name === 'lesson.edit')) {
                    return false;
                } else {
                    return true;
                }
            },
            signedIn() {
                return window.App.signedIn;
            },
            user(){
                return  window.App.user;
            },
        },
    }
</script>
