<template>
    <city-form action="/api/admin/region/store" :city-form="cityForm" @close="closeModal"></city-form>
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
                    title: ""
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
