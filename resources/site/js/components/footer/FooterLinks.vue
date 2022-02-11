<template>
    <div class="col-sm-12 col-md-12 col-lg-2">
        <div class="b-footer-links">

            <a class="b-footer-links__item b-footer-links__item--legal-info" :href="justice_link">
                Юридическая информация
            </a>
            <a class="b-footer-links__item b-footer-links__item--legal-info" :href="faq_link">
                <svg class="page-header-top-nav__icon">
                    <use xlink:href="/images/sprite.svg#help"></use>
                </svg>
                Поддержка
            </a>
            <a class="b-footer-links__item" :href="email">{{ email }}</a>
            <a class="b-footer-links__item" :href="phone_footer">{{ phone_footer }}</a>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        justice_link: {
            required:true,
        },
        faq_link: {
            required:true,
        },
        email: {
            required:true,
        },
        phone_footer: {
            required:true,
        },
    },
    data () {
        return {

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
    font-size rem(14px)
    font-weight 200
    color #3D3D3D
    &:hover
        text-decoration none
    +below(md)
        font-size rem(16px)

</style>

