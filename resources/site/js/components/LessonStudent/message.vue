<template>
    <el-button type="primary" icon="el-icon-message" style=" text-transform: uppercase" @click.prevent="sendMsg">
        Написать преподавателю
    </el-button>
</template>
<script>
export default {
    props: {
        lesson_id: {
            type:Number
        },
    },
    data() {
        return {

        }
    },
    methods: {
        sendMsg() {
            axios.post('/api/profile/chats/createOrGo',{lesson_id: this.lesson_id})
                .then((response)=>{
                    location.href=response.data;
                })
                .catch((error)=>{
                    console.log(error)
                })
        },

    }
}
</script>
