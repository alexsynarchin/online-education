<template>
    <el-tabs type="card">
        <el-tab-pane label="Регионы">
            <regions></regions>
        </el-tab-pane>
        <el-tab-pane label="Города">
            <cities></cities>
        </el-tab-pane>
        <el-tab-pane label="Учебные заведения">
            <edu-institutions></edu-institutions>
        </el-tab-pane>
    </el-tabs>
</template>
<script>
import Cities from "./cities";
import Regions from "./regions";
import EduInstitutions from "./edu-institutions";
    export default {
        components: {
            Cities, Regions, EduInstitutions,
        },
    }
</script>
