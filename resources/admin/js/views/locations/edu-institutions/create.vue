<template>
    <city-form action="/api/admin/edu-institution/store" :city-form="cityForm" @close="closeModal"></city-form>
</template>
<script>
    import CityForm from './components/form';
    export default {
        components: {
            CityForm
        },
        data() {
            return {
                cityForm: {
                    title: "",
                    city_id: null,
                    type: "",
                    region: {
                        id:null,
                        title:"",
                    }
                }
            }
        },
        methods: {
            closeModal() {
                this.$emit('close');
            }
        }
    }
</script>
