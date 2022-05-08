<template>
    <section>
        <city-form v-if="loaded" :action="'/api/admin/edu-institution/' + id + '/update'" :city-form="cityForm"  @close="closeModal"></city-form>
    </section>

</template>
<script>
    import CityForm from './components/form';
    export default {
        props:['id'],
        components: {
            CityForm,
        },
        data() {
            return {
                loaded:false,
                cityForm: {},
            }
        },
        methods:{
            closeModal() {
                this.$emit('close');
            },
            getData() {
                axios.get('/api/admin/edu-institution/'+this.id+ '/show')
                    .then((response) => {
                        this.cityForm = response.data;
                        this.loaded = true;
                    })
            }
        },
        mounted() {
            this.getData();
        }
    }
</script>
