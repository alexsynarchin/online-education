<template>
    <section class="course-item">
        {{course.title}}
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
