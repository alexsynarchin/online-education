<template>
    <el-dialog
        title="Tips"
        :visible.sync="dialogVisible"
        width="30%"
        :before-close="handleClose">

    <el-button @click="dialogVisible = false">Cancel</el-button>
    <el-button type="primary" @click="dialogVisible = false">Confirm</el-button>
  </span>
    </el-dialog>
</template>
<script>
    export default {
        data() {
            return {
                dialogVisible:false,
            }
        },
        methods: {
            handleClose() {

            },
        }
    }
</script>
