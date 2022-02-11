<template>
    <el-tabs type="card" @tab-click="handleClick" v-model="activeTab">
        <el-tab-pane label="Общие" name="common">
            <common></common>
        </el-tab-pane>

    </el-tabs>
</template>
<script>
import common from "./components/common";
    export default {
        components:{
            common,
        },
        data() {
            return {
                activeTab: 'common'
            };
        },
        methods: {
            handleClick(tab, event) {
                console.log(tab, event);
            }
        },
    }
</script>
