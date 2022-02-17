<template>
    <section>
        <page-form
            v-if="loaded"
            :form="form"
            :formAction="'/api/admin/article/' + id + '/update'"
            @closeModal="closeModal"
        ></page-form>
    </section>

</template>
<script>
    import form from "./components/form";
    export default {
        components:{
            'PageForm':form,
        },
        props:['id'],
        data() {
            return {
                loaded:false,
                form: {

                }
            }
        },
        methods:{
            closeModal(value) {
                this.$emit('closeModal',value)
            },
            getFormData() {
              this.$root.isLoading = true;
               return axios.get('/api/admin/article/' + this.id)
                    .then((response) => {
                        this.form = response.data;
                        this.loaded = true;
                      this.$root.isLoading = false;

                    })
            }
        },
        async mounted() {
            await this.getFormData();
        }
    }
</script>
