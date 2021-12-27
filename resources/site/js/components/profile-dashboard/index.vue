<template>
    <div class="b-profile-user">
        <div class="container">
            <div class="row">
                <ProfileSidebar :user="user"></ProfileSidebar>
                <div class="col-12 col-sm-12 col-md-12 col-lg-9">
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
            signedIn() {
                return window.App.signedIn;
            },
            user(){
                return  window.App.user;
            },
        },
    }
</script>
