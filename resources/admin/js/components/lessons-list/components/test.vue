<template>
    <section class="lesson__test">
        <h5>Вопросы:</h5>
        <el-card class="box-card" style="margin-bottom: 1rem"
                 v-for="(question,index) in test.questions"
                 v-bind:key="question.id"
                 v-bind:index="index"
                 v-if="test.questions.length"
        >
            <div slot="header" class="d-flex justify-content-between">
                <div class="question-item__content">
                    <figure class="question-item__img" v-if="question.image"><img :src="question.preview"> </figure>
                    <div v-html="question.text"></div>
                </div>
                <el-tag style="margin-left: 1rem">Вопрос {{index + 1}}</el-tag>
            </div>
            <label>Варианты ответа:</label>
            <div v-for="option in question.options"  class="text item d-flex align-items-center question-option__item" >
                <i class="el-icon-success" v-if="option.right_answer"></i>
                <i class="el-icon-error" v-else></i>
                <div class="question-option__content">
                    <figure class="question-option__img" v-if="option.image"><img :src="option.preview"> </figure>
                    <div class="question-option__text" v-html="option.text"></div>
                </div>

            </div>
        </el-card>
    </section>
</template>
<script>
export default {
    props:{
        test: {
            type:Object,
        }
    },

    methods:{

    },
    data(){
        return{

        }
    },
    mounted(){

    },
}
</script>
<style lang="scss">
.lesson__test{
    p{
        margin-bottom: 6px;
    }
    .el-card{
        &__header{
            p{
                margin-bottom: 0;
            }
        }
    }
}
.el-icon-success{
    color: green;
    font-size: 1.4rem;
}
.el-icon-error{
    color: red;
    font-size: 1.4rem;
}


</style>
