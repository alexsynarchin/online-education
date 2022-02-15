<template>
    <page-form
        :form="form"
        :formAction="'/api/admin/static-page/store'"
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
