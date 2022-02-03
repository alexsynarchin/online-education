<template>
    <div class="col-sm-12 col-md-12 col-lg-2">
        <div class="b-footer-links">
            <a class="b-footer-links__item b-footer-links__item--legal-info" :href="legalLink">
                Юридическая информация
            </a>
            <a class="b-footer-links__item" :href="mainMail">{{ mainMail }}</a>
            <a class="b-footer-links__item" :href="mainPhone">{{ mainPhone }}</a>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            legalLink: '/legallink',
            mainMail: 'mail@domains.com',
            mainPhone: '8 (800) 500-82-64'
        }
    }
}
</script>

<style lang="stylus" scoped>


@import '../../../stylus/_mixins'
@import '../../../stylus/_rapture'

rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

.b-footer-links
    +below(md)
        display flex
        flex-direction column
        align-items center
        margin-top 15px

.b-footer-links__item
    display block
    margin-bottom 20px
    font-family "RobotoRegular", sans-serif
    font-size rem(14px)
    font-weight 200
    color #3D3D3D
    &:hover
        text-decoration none
    +below(md)
        font-size rem(16px)

</style>

