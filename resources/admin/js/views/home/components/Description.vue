<template>
    <div class="teacher-container" style="max-width: 900px">
        <section class="mb-3">
            <div class="mb-1" style="font-size: 19px">
                <label style="font-weight: bold">Тип образования:</label>
                <span>{{edu_type_title}}</span>
            </div>
            <div class="mb-1" style="font-size: 19px" v-if="course.direction">
                <label style="font-weight: bold">Направление:</label>
                <span>{{course.direction.title}}</span>
            </div>
            <div class="mb-1" style="font-size: 19px" v-if="course.specialty">
                <label style="font-weight: bold">{{(course.edu_type_id === 4) ? 'Программа' : 'Специальность' }}:</label>
                <span>{{course.specialty.title}}</span>
            </div>
        </section>

        <div class="mb-4" v-if="course.themes.length > 0">
            <h6>Неопобликованные теги:</h6>
            <div class="d-flex flex-wrap">
                <el-tag type="danger" :key="theme.id" v-for="theme in course.themes">
                    {{theme.title}}
                </el-tag>
            </div>
        </div>

        <div v-if="course.subject.active === 0" class="mb-4">
            <h6>Неопобликованный предмет:</h6>
            <el-tag type="danger" >
                {{course.subject.title}}
            </el-tag>
        </div>
        <div v-if="course.direction.active === 0" class="mb-4">
            <h6>Неопобликованное направление:</h6>
            <el-tag type="danger" >
                {{course.direction.title}}
            </el-tag>
        </div>
        <div v-if="course.specialty && course.specialty.active === 0" class="mb-4" >
            <h6>Неопобликованная специальность:</h6>
            <el-tag type="danger" >
                {{course.specialty.title}}
            </el-tag>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-4">
                <div class="preview-lesson-wrap">
                    <img  alt="" class="preview-lesson-img"
                          :src="course.image"
                    >
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-8">
                <div class="preview-wrapper">
                    <div class="preview-lesson-des">
                        <div class="preview-lesson-des__left">
                            <div class="preview-stars">
                                <el-rate
                                    :value="Number(course.rating)"
                                    disabled
                                    disabled-void-color="#bbbbbb"
                                    class="lesson-rating lesson-rating--readonly"
                                >
                                </el-rate>

                                <!--<span class="preview-star__count">21 оценка</span>-->
                            </div>
                            <div class="preview-author">
                                <span class="preview-author__title">Автор:</span>
                                <div class="preview-author-group">
                                    <img  alt="" class="preview-author-group__img"
                                          :src="course.author.avatar"
                                    >
                                    <span class="preview-author-group__fullname">
                                                {{course.author.name}}<br>
                                                {{course.author.last_name}}<br>
                                                {{course.author.surname}}
                                            </span>
                                </div>
                            </div>
                        </div>

                        <div class="preview-lesson-des__right">
                            <div class="preview-price-group">
                                <div class="preview-price mb-2">
                                    <span class="preview-price__title">Стоимость курса:</span>
                                    <span class="preview-price__ruble">{{Math.trunc(course.price)}} РУБ</span>
                                </div>
                                <div class="lesson_status text-center">
                                    <el-tag type="success" v-if="course.status == 2">
                                        Опубликован
                                    </el-tag>
                                    <el-tag type="warning" v-if="course.status == 0">
                                        Черновик
                                    </el-tag>
                                    <el-tag type="warning"  v-if="course.status == 1">
                                        На модерации
                                    </el-tag>
                                    <el-tag type="danger"  v-if="course.status == 3">
                                        Отклонен
                                    </el-tag>
                                </div>
                                <!--<a href="#" class="preview-price__btn">Купить урок</a>-->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            course: {
                type: Object,
                required:true
            }
        },
        computed: {
            edu_type_title:function (){
                let title = '';
                if(this.course.edu_type_id === 1) {
                    title = 'Школьное образование'
                }
                if(this.course.edu_type_id === 2) {
                    title = 'Среднее образование'
                }
                if(this.course.edu_type_id === 3) {
                    title = 'Высшее образование'
                }
                if(this.course.edu_type_id === 4) {
                    title = 'Дошкольное образование'
                }
                return title;
            }
        }
    }
</script>
<style src="./styles/description.styl" lang="stylus"></style>
