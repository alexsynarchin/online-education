<template>
    <section class="lesson-test" v-if="loaded && test">
        <button  class="button" style="margin-right: 20px" @click="startTest" v-if="test.passed" :disabled="!can_test">Пройти тест заново</button>
        <button  class="button" style="margin-right: 20px" @click="startTest" v-else>Пройти тест</button>
        <button class="button button--success" @click.prevent="resultVisible= true" v-if="test.passed">Смотреть результаты теста</button>
        <el-dialog
            :visible.sync="dialogVisible"
            :fullscreen="true"
        >
        <h2 class="page-title">{{'Тест к уроку ' + lesson_title}}</h2>
        <form action="" class="test-form">
            <fieldset class="test-form-item" v-for="(question, question_index) in test.questions">
                <div class="test-header">
                    <span class="test-header__count">{{question_index + 1}}</span>
                    <div class="test-header__title" v-html="question.text"></div>
                </div>
                <div class="test-image-wrap" v-if="question.preview">
                    <img :src="question.preview"/>
                </div>
                <div class="test-body">
                    <div class="test-body-item" v-for="(option, option_index) in question.options">
                        <span class="test-body-item__number">{{option_index+1}})</span>
                        <input type="checkbox" v-model="option.answer"  class="test-body-item__checkbox">
                        <div class="test-body-item__content d-flex">
                            <div class="test-option__image-wrap" v-if="option.preview">
                                <img :src="option.preview"/>
                            </div>
                            <div class="test-body-item__questation" v-html="option.text"></div>
                        </div>


                    </div>
                </div>
            </fieldset>
            <button class="test-form-btn" type="submit" @click.prevent="testPass(test)">Отправить</button>
        </form>
        </el-dialog>
        <el-dialog
            :visible.sync="resultVisible"

            >
            <section>
                <h4>Результаты теста</h4>
                <ul class="test-result-list">
                    <li class="test-result-list__item" v-for="(answer,index) in answers">
                        <i class="el-icon-success" style="color:green;" v-if="answer.correct"></i>
                        <i class="el-icon-error" style="color: red" v-else></i>
                        <section class="test-result-list__item-question" v-html="answer.question.text"></section>
                    </li>
                </ul>
            </section>
            <el-button type="primary" @click="resultVisible=false">Закрыть</el-button>
        </el-dialog>

    </section>
</template>
<script>
    import Button from "../buying/button";
    export default {
        components: {Button},
        props: {
            lesson_title: {
                type:String,
            },
            id:{
                type:Number,
                required:true,
            }
        },
        data() {
            return {
                loaded:false,
                test: {},
                result:{},
                answers:[],
                can_test:true,
                dialogVisible:false,
                resultVisible:false,
            }
        },
        methods: {
            startTest(){
                this.dialogVisible = true;
            },
            getResult() {
                axios.get('/api/education/test/' + this.id +  '/result')
                    .then((response) => {
                        this.answers = response.data;
                    })
            },
            getTests() {
                axios.get('/api/education/test/' + this.id)
                .then((response) => {
                    this.test = response.data.test;
                    this.can_test = response.data.can_test
                    this.getResult();
                    this.loaded =true;
                })
            },
            testPass(test){
                var results = [];
                for (var i = 0; i < test.questions.length; i++){
                    results[i] = {question_id: test.questions[i].id, answers: []};
                    for (var k = 0; k < test.questions[i].options.length; k++){
                        results[i].answers[k] = {
                            option_id: test.questions[i].options[k].id,
                            answer:test.questions[i].options[k].answer,
                            right_answer: test.questions[i].options[k].right_answer,
                        }
                    }
                }
                axios.post('/api/education/test/' + test.id + '/pass', {results:results})
                    .then((response)=>{
                        this.dialogVisible = false;
                        this.getResult();
                        this.getTests();
                        this.resultVisible = true;
                    })
                    .catch((error)=>{
                        console.log(error)
                    })
            }
        },
        mounted() {
            this.getTests();
        }
    }
</script>
