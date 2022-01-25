<template>
    <section>
        <h1 class="page-title">
            Категории контента
        </h1>
        <el-tabs type="card">
            <el-tab-pane label="Виды образования">
                <edu-type-list></edu-type-list>
            </el-tab-pane>
            <el-tab-pane label="Направления и специальности">
                <edu-directions></edu-directions>
            </el-tab-pane>
            <el-tab-pane label="Предметы">
                <edu-subjects-list></edu-subjects-list>
            </el-tab-pane>
            <el-tab-pane label="Темы курсов">
                <edu-themes-list></edu-themes-list>
            </el-tab-pane>
        </el-tabs>
    </section>
</template>
<script>
    import EduTypeList from "./components/EduTypeList";
    import EduSubjectsList from "./components/EduSubjectsList";
    import EduThemesList from "./components/EduThemesList";
    import EduDirections from "./components/EduDirections";
    export default {
        components: {
            EduTypeList, EduSubjectsList, EduThemesList, EduDirections,
        }
    }
</script>
