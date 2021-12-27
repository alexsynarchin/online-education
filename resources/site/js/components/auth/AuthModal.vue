<template>
    <modal
        name="isLogin"
        transition="nice-modal-fade"
        :min-width="200"
        :max-width="800"
        :delay="100"
        :adaptive="true"
        :scrollable="true"
        width="90%"
        height="auto">
        <div class="modal-content">
            <div class="modal-content-upline">
                <button class="modal-content__close" @click="closeModal"></button>
            </div>
            <tabs>
                <tab name="Вход" :selected="true">
                    <login></login>
                </tab>
                <tab name="Регистрация">
                    <register @setProfileType="setProfileType"></register>
                </tab>
            </tabs>
            <social-auth :profile_type="profile_type"></social-auth>
        </div>
    </modal>
</template>
<script>
    import Tabs from "@/common/js/components/tabs/Tabs";
    import Tab from "@/common/js/components/tabs/Tab";
    import Login from "./Login";
    import Reg from "./Reg";
    import SocialAuth from './SocialAuth';
export default {
    name: 'ModalLogin',
    components:{
        'Tabs': Tabs,
        'Tab': Tab,
        'Login': Login,
        'Register': Reg,
        'SocialAuth':SocialAuth,
    },
    data () {
        return {
            time: 0,
            duration: 5000,
            activeTab:'login',
            profile_type:'',
        }
    },
    methods: {
        show () {
            this.$modal.show('isLogin');
        },
        closeModal () {
            this.$modal.hide('isLogin')
        },
        setProfileType(profile_type) {
            this.profile_type= profile_type;
            console.log(this.profile_type);
        }
    }
}
</script>

<style lang="scss">
    @import '../../../../../node_modules/bootstrap/scss/bootstrap';
.v--modal{

    border-radius: 15px !important;
}
.modal-content{
    padding: 10px 20px 30px 20px;
    &-upline{
        display: flex;
        justify-content: flex-end;
    }
    &__close{
        position: relative;
        width: 40px;
        height: 40px;
        border: none;
        background: none;
        &:focus,&:active{
            outline: none;
        }
        &::before{
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            width: 30px;
            height: 2px;
            background: #BEBEBE;
            transform: rotate(45deg);
        }
        &::after{
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            width: 30px;
            height: 2px;
            background: #BEBEBE;
            transform: rotate(-45deg);
        }
    }
}
.b-tab-questation{
    @include media-breakpoint-down(sm){
        text-align: center;
    }
    &__item{
        @include media-breakpoint-down(sm){
            margin-right: 0px !important;
        }
    }
}

.modal-radio-group{
    @include media-breakpoint-down(sm){
        display: flex;
        flex-direction: column;
    }
}
</style>
