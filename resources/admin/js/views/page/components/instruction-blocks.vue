<template>
    <section class="blocks-by-type mt-4 mb-4">

        <text-gallery sort="" :delete_img="form.delete_img" :blocks="form.instr_blocks"></text-gallery>
    </section>
</template>
<script>
import TextGallery from "./text-gallery";
export default {
    components: {
        TextGallery,
    },
    props: {
        blocks: {
            type:Object,
        },
    },
    data() {
        return {
            form: {
                instr_blocks:[],
                delete_img:[],
            },
        }
    },
    methods: {
        sort() {
            console.log('sort');
        },
        prepareForm() {

            if(this.blocks.instr_blocks) {
                this.form.instr_blocks = this.blocks.instr_blocks;
            }
        },
        submitForm() {
            return this.form;
        },
    },
    async mounted() {
        await this.prepareForm();
    },
}
</script>
