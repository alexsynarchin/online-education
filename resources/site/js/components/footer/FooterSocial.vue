<template>
    <div class="col-sm-12 col-md-12 col-lg-2">
        <div class="b-footer-soc">
            <span class="b-footer-soc__title">Социальные сети</span>
            <div class="b-footer-soc-links">
                <a :href="socialLink.href" class="b-footer-soc-link" v-for="(socialLink, index) in socialLinks" :key="index">
                    <img class="b-footer-soc-link__img" :src="socialLink.src" :alt="socialLink.alt">
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:[
        'instagram_link','vk_link','facebook_link'
    ],
    data () {
        return {
            socialLinks: [
                {
                    href: this.instagram_link,
                    src: ('/images/instagram.svg'),
                    alt: 'instagram'
                },
                {
                    href: this.vk_link,
                    src: '/images/vk_verni_stenu.svg',
                    alt: 'vk'
                },
                {
                    href: this.facebook_link,
                    src: ('/images/facebook.svg'),
                    alt: 'facebook'
                }

            ]
        }
    }

}
</script>

<style lang="stylus" scoped>

@import '../../../stylus/_mixins'
@import '../../../stylus/_rapture'

rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'



.b-footer-soc
    +below(md)
        display flex
        flex-direction column
        align-items center

.b-footer-soc-links
    margin-top 10px

.b-footer-soc-link
    display inline-block
    margin-right 10px

.b-footer-soc-link__img
    width 30px
    height 30px

</style>
