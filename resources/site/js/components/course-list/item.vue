<template>
    <section class="course-item">
        <div class="course-item__heading">
            <a :href="'/catalog/' + course.edu_type.slug + '/' + course.slug"   class="course-item__link">
                <h4 class="course-item__title">
                    {{course.title}}
                </h4>
            </a>

            <course-rating
                :count="course.rating_count"
                :rating="course.rating"
                v-if="course.rating > 0"
            ></course-rating>

        </div>
        <div class="course-item__content">
            <figure class="course-item__img">
                <img :src="course.image" >
            </figure>
            <div class="course-item__main">
                <p class="course-item__descr">
                    {{course.description}}
                </p>
                <ul class="course-item-lessons">
                    <li class="course-item-lessons__item course-item-lessons__item--preview"
                        v-for="(lesson, index) in course.lessons" v-if="lessons_slice && index < 3">
                        <a :href="'/catalog/' + course.edu_type.slug + '/' + course.slug + '/' + lesson.slug"
                           class="course-item-lessons__link">
                            <span class="course-item-lessons__title course-item-lessons__title--icons">
                                {{lesson.title}}
                            </span>
                            <ul class="course-item__types"
                            v-if="lesson.type_text || lesson.type_video || lesson.type_image || lesson.type_audio"
                            >
                                <li class="course-item__types-item" v-if="lesson.type_video">
                                    <el-tooltip class="item" effect="dark" content="В данном уроке есть видео" placement="top-start">
                                        <svg class="course-item__icon">
                                            <use xlink:href="/assets/site/images/sprites.svg?ver=14#sprite-video-icon"></use>
                                        </svg>
                                    </el-tooltip>
                                </li>
                                <li class="course-item__types-item" v-if="lesson.type_image">
                                    <el-tooltip class="item" effect="dark" content="В данном уроке есть изображения" placement="top-start">
                                        <svg class="course-item__icon">
                                            <use xlink:href="/assets/site/images/sprites.svg?ver=14#sprite-image-icon"></use>
                                        </svg>
                                    </el-tooltip>
                                </li>
                                <li class="course-item__types-item" v-if="lesson.type_text">
                                    <el-tooltip class="item" effect="dark" content="В данном уроке есть текст" placement="top-start">
                                        <svg class="course-item__icon">
                                            <use xlink:href="/assets/site/images/sprites.svg?ver=14#sprite-text-icon"></use>
                                        </svg>
                                    </el-tooltip>
                                </li>
                                <li class="course-item__types-item" v-if="lesson.type_audio">
                                    <el-tooltip class="item" effect="dark" content="В данном уроке есть аудио" placement="top-start">
                                        <svg class="course-item__icon">
                                            <use xlink:href="/assets/site/images/sprites.svg?ver=14#sprite-audio-icon"></use>
                                        </svg>
                                    </el-tooltip>
                                </li>
                            </ul>
                            <span class="course-item-lessons__price">
                                {{lesson.price_user}} ₽
                            </span>
                        </a>
                    </li>
                    <li class="course-item-lessons__item" v-for="(lesson, index) in course.lessons" v-if="!lessons_slice">
                        <a :href="'/catalog/' + course.edu_type.slug + '/' + course.slug + '/' + lesson.slug"
                           class="course-item-lessons__link">
                             <span class="course-item-lessons__title course-item-lessons__title--icons">
                                {{lesson.title}}
                            </span>
                            <ul class="course-item__types"
                                v-if="lesson.type_text || lesson.type_video || lesson.type_image || lesson.type_audio"
                            >
                                <li class="course-item__types-item" v-if="lesson.type_video">
                                    <el-tooltip class="item" effect="dark" content="В данном уроке есть видео" placement="top-start">
                                        <svg class="course-item__icon">
                                            <use xlink:href="/assets/site/images/sprites.svg?ver=14#sprite-video-icon"></use>
                                        </svg>
                                    </el-tooltip>
                                </li>
                                <li class="course-item__types-item" v-if="lesson.type_image">
                                    <el-tooltip class="item" effect="dark" content="В данном уроке есть изображения" placement="top-start">
                                        <svg class="course-item__icon">
                                            <use xlink:href="/assets/site/images/sprites.svg?ver=14#sprite-image-icon"></use>
                                        </svg>
                                    </el-tooltip>
                                </li>
                                <li class="course-item__types-item" v-if="lesson.type_text">
                                    <el-tooltip class="item" effect="dark" content="В данном уроке есть текст" placement="top-start">
                                        <svg class="course-item__icon">
                                            <use xlink:href="/assets/site/images/sprites.svg?ver=14#sprite-text-icon"></use>
                                        </svg>
                                    </el-tooltip>
                                </li>
                                <li class="course-item__types-item" v-if="lesson.type_audio">
                                    <el-tooltip class="item" effect="dark" content="В данном уроке есть аудио" placement="top-start">
                                        <svg class="course-item__icon">
                                            <use xlink:href="/assets/site/images/sprites.svg?ver=14#sprite-audio-icon"></use>
                                        </svg>
                                    </el-tooltip>
                                </li>
                            </ul>
                            <span class="course-item-lessons__price">
                                {{lesson.price_user}} ₽
                            </span>
                        </a>
                    </li>
                </ul>
                <a :href="'/catalog/' + course.edu_type.slug + '/' + course.slug"
                   @click.prevent="sliceState"
                   class="course-item-lessons__btn" v-if="course.lessons.length > 3">
                    <template v-if="lessons_slice">
                        Полный список уроков
                    </template>
                    <template v-else>
                        Скрыть полный список уроков
                    </template>

                </a>
            </div>
            <div class="course-item__right course-item__right--text-right">
                <div class="course-item__price">
                    {{course.price}} ₽
                </div>
                <div class="course-item__actions">
                    <buy-btn :buying_id="course.id" v-if="!course.user_buy"></buy-btn>
                    <a
                        :href="'/catalog/' + course.edu_type.slug + '/' + course.slug"
                        class="course-item__btn btn" v-else>
                        Перейти
                    </a>
                </div>

            </div>
        </div>
        <div class="course-item__footer">
            <div class="course-item__author">
                <label class="course-item__author-label">
                    Автор:
                </label>
                <a :href="'/search-teachers/' + course.author.id" class="course-item__author-value">
                                    {{course.author.name}}
                {{course.author.surname}}
                </a>
                <el-tooltip class="item" effect="dark" content="Кликнете по имени преподавателя чтобы посмотреть его курсы" placement="top-start">
                    <svg class="course-item__author-icon">
                        <use xlink:href="/assets/site/images/sprites.svg?ver=12#sprite-question-icon"></use>
                    </svg>
                </el-tooltip>
            </div>
        </div>
    </section>

</template>
<script>
export default {
    props:{
        course:{
            type:Object,
        }
    },
    data() {
      return {
          lessons_slice: true,
      }
    },
    methods: {
        sliceState()
        {
            this.lessons_slice = !this.lessons_slice
        }
    },

}
</script>
