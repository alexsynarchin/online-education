<template>
    <section class="course-item">
        <div class="course-item__heading">
            <h4 class="course-item__title">
                {{course.title}}
            </h4>
        </div>
        <div class="course-item__content">
            <figure class="course-item__img">
                <img :src="course.image" >
            </figure>
            <div class="course-item__main">
                <p class="course-item__descr">
                    {{course.description}}
                </p>
            </div>
            <div class="course-item__right">

            </div>
        </div>
    </section>
</template>
<script>
    export default {
        props:{
            course:{
                type:Object,
                required:true,
            }
        }
    }
</script>
