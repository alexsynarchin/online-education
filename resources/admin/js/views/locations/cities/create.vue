<template>
    <city-form action="/api/admin/city/store" :city-form="cityForm" @close="closeModal"></city-form>
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
                    region_id: null,
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
