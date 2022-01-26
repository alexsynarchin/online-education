<template>
    <div class="teacher-container" style="max-width: 900px">
        <h6>Неопобликованные теги:</h6>
        <div class="d-flex flex-wrap mb-4">
            <el-tag type="danger" :key="theme.id" v-for="theme in course.themes">
                {{theme.title}}
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

    }
</script>
<style src="./styles/description.styl" lang="stylus"></style>
