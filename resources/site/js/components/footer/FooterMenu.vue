<template>
    <div class="col-lg-6">
        <nav class="b-footer-nav">
            <ul class="b-footer-menu">
                <li class="b-footer-menu-nav__item b-footer-menu-nav__item--hover"  v-for="(menuLinkItem, index) in footerMenuItemsOne" :key="index">
                    <a class="b-footer-menu-nav__item_link" :href="menuLinkItem.link">{{ menuLinkItem.title }}</a>
                </li>
            </ul>
        </nav>

    </div>
</template>

<script>
export default {
    data () {
        return {
            footerMenuItemsOne: [
                {
                    title: 'Дошкольное образование',
                    link: '#'
                },
                {
                    title: 'Как пользоваться?',
                    link: '/faq'
                },
                {
                    title: 'Школьное образование',
                    link: '/catalog/school-education'
                },
                {
                    title: 'Преподавателям',
                    link: '/for-teachers'
                },
                {
                    title: 'Среднее образование',
                    link: '/catalog/secondary-special'
                },

                {
                    title: 'Блог',
                    link: '/blog'
                },
                {
                    title: 'Высшее образование',
                    link: '/catalog/higher-education'
                },

                {
                    title: 'О Educall',
                    link: '/about'
                }
            ]
        }
    }
}
</script>

<style lang="stylus" scoped>
@import '../../../stylus/_mixins'

.b-footer-nav
    height 100%

.b-footer-menu
    display block
    margin 0

.b-footer-menu-nav__item
    width 50%
    float left
    list-style-type none

.b-footer-menu-nav__item--hover
    transition transform .25s ease
    &:hover
        transform translateY(-5px)

.b-footer-menu-nav__item_link
    display inline-block
    margin-bottom 20px
    font-family "RobotoRegular", sans-serif
    font-size rem(14px)
    font-weight 200
    color #3D3D3D
    &:hover
        text-decoration none
</style>

