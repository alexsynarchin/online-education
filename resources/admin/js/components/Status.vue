<template>
    <el-tag :type="status[0].type">
     {{status[0].text}}
    </el-tag>
</template>
<script>
    export default {
        props: {
            active_status: {
                type:Number,
                required:true,
            }
        },
        data() {
            return {
                statuses: [
                    {
                        value: 0,
                        type:"warning",
                        text:"Черновик"
                    },
                    {
                        value: 1,
                        type:"warning",
                        text:"Модерация"
                    },
                    {
                        value: 2,
                        type:"success",
                        text:"Опубликован"
                    },
                    {
                        value: 3,
                        type:"danger",
                        text:"Отклонен"
                    },
                ]
            }
        },
        computed: {
            status: function() {
                return this.statuses.filter(status => {
                    return status.value == this.active_status;
                })
            }
        }
    }
</script>
