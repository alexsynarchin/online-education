<template>
    <el-tabs type="card">
        <el-tab-pane label="Запросы">
            <withdraws></withdraws>
        </el-tab-pane>
        <el-tab-pane label="История">
            <history></history>
        </el-tab-pane>
    </el-tabs>
</template>
<script>
import Withdraws from "./components/withdraws";
import History  from "./components/history";
    export default {
        components: {
            Withdraws, History
        }
    }
</script>
