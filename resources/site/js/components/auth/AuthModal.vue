<template>
    <el-dialog
        :visible.sync="showModal"
        class="auth-modal"
        >
        <tabs>
            <tab name="Вход" :selected="true">
                <login></login>
            </tab>
            <tab name="Регистрация">
                <register @setProfileType="setProfileType"></register>
            </tab>
        </tabs>
        <social-auth :profile_type="profile_type"></social-auth>
    </el-dialog>
</template>
<script>
    import Tabs from "@/common/js/components/tabs/Tabs";
    import Tab from "@/common/js/components/tabs/Tab";
    import Login from "./Login";
    import Reg from "./Reg";
    import SocialAuth from './SocialAuth';
    import EventBus from "../../EventBus";
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
            showModal:false,
            time: 0,
            duration: 5000,
            activeTab:'login',
            profile_type:'',
            redirect_path:"",
        }
    },
    methods: {
        show () {
           this.showModal= true;
        },
        closeModal () {
            this.showModal =false;
        },
        setProfileType(profile_type) {
            this.profile_type= profile_type;
            console.log(this.profile_type);
        }
    },
    created() {
        EventBus.$on('show-auth-modal', this.show)
    }
}
</script>
