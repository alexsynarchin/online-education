<template>
    <section class="blocks-by-type mt-4 mb-4">
        <text-gallery :delete_img="form.delete_img" :blocks="form.instr_blocks"></text-gallery>
    </section>
</template>
<script>
import TextGallery from "./text-gallery";
export default {
    components: {
        TextGallery,
    },
    data() {
        return {
            form: {
                instr_blocks:[],
                delete_img:[],
            },
        }
    },
}
</script>
