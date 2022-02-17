<template>
    <page-form
        :form="form"
        :formAction="'/api/admin/article/store'"
        @closeModal="closeModal"
    ></page-form>
</template>
<script>
    import form from "./components/form";
    export default {
        components:{
            'PageForm':form,
        },
        data() {
            return {
                form:{
                    title:'',
                    slug:'',
                    image:"",
                    active:true,
                    text:"",
                    seo:{},
                }
            }
        },
        methods:{
            closeModal(value) {
                this.$emit('closeModal',value)
            }
        }
    }
</script>
