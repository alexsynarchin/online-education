<template>
    <div class="col-sm-12 col-md-12 col-lg-2">
        <a class="b-footer__logo" :href="url">
            <img class="b-footer__logo-img" src="/images/logo-2.svg" alt="logo">
        </a>
    </div>
</template>

<script>
    export default {
        name: "footerLogo",
        data () {
            return {
                url: 'google.com'
            }
        }
    }
</script>

<style lang="stylus" scoped>


@import '../../../stylus/_mixins'
@import '../../../stylus/_rapture'

rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'



.b-footer__logo
    width: 100%
    display: flex
    justify-content: center
    align-items: center
    +below(lg)
        margin-bottom 30px

.b-footer__logo-img
    width: 125px
    height: 90px
    display: block


</style>
