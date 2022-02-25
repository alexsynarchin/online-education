<template>
    <section class="lesson-test" v-if="loaded && test">

        <h4 class="lesson-test__title">
            Тест к уроку
        </h4>
        <div class="lesson-test__results">
            <template v-if="test.passed">
                Правильных ответов: {{correct_count}} из {{test.questions.length}}
            </template>
            <template v-else>
                Не пройден
            </template>
        </div>
        <div class="lesson-test__btns">
            <button  class="button" style="margin-right: 20px" @click="startTest" v-if="test.passed" :disabled="!can_test">Пройти тест заново</button>
            <button  class="button" style="margin-right: 20px" @click="startTest" v-else>Пройти тест</button>
            <button class="button button--success" @click.prevent="resultVisible= true" v-if="test.passed">Смотреть результаты</button>
        </div>
        <el-dialog
            class="lesson-test-modal"
            :visible.sync="dialogVisible"
            width="50%"
            :title="'Тест к уроку: ' + lesson_title"
        >
        <form action="" class="test-form">
            <div class="test-header">
                    <span class="test-header__count">
                        Вопрос {{question_index + 1}}
                    </span>
                    <div class="test-header__right">
                        <span class="test-header__current-num">
                            Пройдено: {{question_index}} из {{test.questions.length}}
                        </span>
                    </div>
            </div>
            <fieldset class="test-form-item" :class="{'test-form-item--current': index === question_index}" v-for="(question, index) in test.questions" >
                <section class="test-question">
                    <div class="test-question__text" v-html="question.text"></div>
                    <div class="test-question__image" v-if="question.preview">
                        <img :src="question.preview"/>
                    </div>
                </section>

                <div class="test-body">
                    <div class="test-body-item" v-for="(option, option_index) in question.options">
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
            <button class="test-form-btn" type="submit" @click.prevent="testPass(test)">Ответить</button>
        </form>
        </el-dialog>
        <el-dialog
            :visible.sync="resultVisible"
            class="lesson-test-modal"
            :title="'Тест к уроку: ' + lesson_title"
        >
            <section>

                <ul class="test-result-list">
                    <li class="test-result-list__item" v-for="(answer,index) in answers">
                        <h4 class="test-result-list__item-count">Вопрос {{index+1}}</h4>
                        <section class="test-result-list__item-question" v-html="answer.question.text"></section>
                        <div class="test-result-list__item-type" :class="{
                            'test-result-list__item-type--success': answer.correct,
                            'test-result-list__item-type--danger': !answer.correct
                        }">
                            <i class="el-icon-success" style="color:green;" v-if="answer.correct"></i>
                            <i class="el-icon-error" style="color: red" v-else></i>
                            Ваш ответ:
                        </div>
                       <div class="test-result-list__item-answer" v-html="answer.option.text"></div>

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
                correct_count:0,
                question_index: 0,
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
                        this.answers = response.data.answers;
                        this.correct_count = response.data.correct_count;
                    })
            },
            getTests() {
                axios.get('/api/education/test/' + this.id)
                .then((response) => {
                    this.test = response.data.test;
                    this.can_test = response.data.can_test
                    if(response.data.test.passed) {
                        this.getResult();
                    }
                    this.loaded =true;
                })
            },
            testPass(test){
                this.question_index++;
                if((this.question_index) === test.questions.length) {
                    this.$root.isLoading = true;
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
                            this.$root.isLoading = false;
                            this.question_index = 0;
                            this.dialogVisible = false;
                            this.getResult();
                            this.getTests();
                            this.resultVisible = true;
                        })
                        .catch((error)=>{
                            console.log(error)
                        })
                }

            }
        },
        mounted() {
            this.getTests();
        }
    }
</script>
