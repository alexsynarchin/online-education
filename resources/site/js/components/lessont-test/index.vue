<template>
    <section class="lesson-test" v-if="loaded && tests.length > 0">
        <button  class="button" @click="startTest">Пройти тест</button>
        <el-dialog
            :title="'Тест к уроку ' + lesson_title"
            :visible.sync="dialogVisible"
            :fullscreen="true"
        >
            <section class="mt-4" v-for="(test, index) in tests" v-if="loaded && dialogVisible">
                <form action="" class="test-form">
                    <fieldset class="test-form-item" v-for="(question, question_index) in test.questions">
                        <div class="test-header">
                            <span class="test-header__count">{{question_index + 1}}</span>
                            <div class="test-header__title" v-html="question.text"></div>
                        </div>
                        <div class="test-image-wrap" v-if="question.image">
                            <img :src="question.preview"/>
                        </div>
                        <div class="test-body">
                            <div class="test-body-item" v-for="(option, option_index) in question.options">
                                <span class="test-body-item__number">{{option_index+1}})</span>
                                <input type="checkbox" v-model="option.answer"  class="test-body-item__checkbox">
                                <div class="test-body-item__content">

                                    <div class="test-body-item__questation" v-html="option.text"></div>
                                    <div class="test-option__image-wrap" v-if="option.image">
                                        <img :src="option.preview"/>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </fieldset>
                    <button class="test-form-btn" type="submit" @click.prevent="testPass(test)">Отправить</button>
                </form>
            </section>
        </el-dialog>

    </section>
</template>
<script>
    export default {
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
                tests: [],
                dialogVisible:false,
            }
        },
        methods: {
            startTest(){
                this.dialogVisible = true;
            },
            getTests() {
                axios.get('/api/education/test/' + this.id)
                .then((response) => {
                    this.tests = response.data;
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
