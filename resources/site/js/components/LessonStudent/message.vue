<template>
    <section>
        <el-button type="primary" icon="el-icon-message" style=" text-transform: uppercase" @click.prevent="sendMsg">
            Написать преподавателю
        </el-button>
        <el-dialog
            title="Чат с преподавателем"
            :visible.sync="dialogVisible"
            width="50%"
            :before-close="handleClose">
            <student-chat :chat="chat" v-if="dialogVisible"></student-chat>
        </el-dialog>
    </section>
</template>
<script>
import StudentChat from "../../views/StudentChat/show";
export default {
    components:{
        StudentChat,
    },
    props: {
        lesson_id: {
            type:Number
        },
    },
    data() {
        return {
            dialogVisible:false,
            chat:{},
        }
    },
    methods: {
        handleClose() {
            this.dialogVisible = false;
        },
        sendMsg() {
            axios.post('/api/profile/chats/createOrGo',{lesson_id: this.lesson_id})
                .then((response)=>{
                    this.chat=response.data;
                    this.dialogVisible = true;
                })
                .catch((error)=>{
                    console.log(error)
                })
        },

    }
}
</script>
