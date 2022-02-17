<template>
    <div class="container">
        <figure class="mp-video" v-bind:style="{backgroundImage:'url(\'' + url +'\')'}">
            <figure class="mp-video__btn">
                <img src="/assets/site/images/youtube-play.png" style="margin-left: 10px" @click="openVideo">
            </figure>
        </figure>
        <el-dialog
            :visible.sync="dialogVisible"
            :before-close="handleClose">
            <iframe width="100%"
                    style="height:450px"
                    :src="video_url">
            </iframe>
        </el-dialog>
    </div>
</template>
<script>
    export default {
        props:["video_id"],
        data() {
            return {
                dialogVisible:false,
                url: 'https://img.youtube.com/vi/'+ this.video_id + '/hqdefault.jpg',
                video_url:"",
            }
        },
        methods: {
            openVideo() {
                this.dialogVisible = true;
                this.video_url = 'https://www.youtube.com/embed/' + this.video_id
            },
            handleClose() {
                this.video_url = "";
                this.dialogVisible = false;
            },
        },
    }
</script>
