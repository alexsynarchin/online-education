<template>
    <section class="b-type-education">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="b-type-education__title b-type-education__title--line">
                        А сейчас, начните полноценно <br> осваивать предметы
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="b-type-education__items">
                        <tabs
                        :tabs="tabs"
                        :currentTab="currentTab"
                        :wrapper-class="'b-type-education__items'"
                        :tab-class="'b-type-education__item'"
                        :tab-active-class="'b-type-education__item--hover'"
                        @onClick="handleClick"
                        />
                    </div>


                    <transition name="fade" mode="in-out">
                    <nav class="b-type-education-tabs b-tab-content" role="tablist">

                            <div class="b-tab-content__item" role="tabpanel" v-if="currentTab === 'tab1'">
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Основы экономики</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Правоведение</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Философия</a>
                                </li>

                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Физика</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Химия</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Естествознание</a>
                                </li>

                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Экология</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Астрономия</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Риторика</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Физика</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Химия</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Естествознание</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Основы экономики</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Правоведение</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Философия</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Экология</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Астрономия</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Риторика</a>
                                </li>
                            </div>

                            <div class="b-tab-content__item" role="tabpanel" v-if="currentTab === 'tab2'">
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Физика</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Химия</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Естествознание</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Основы экономики</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Правоведение</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Философия</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Экология</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Астрономия</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Риторика</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Физика</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Химия</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Естествознание</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Основы экономики</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Правоведение</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Философия</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Экология</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Астрономия</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Риторика</a>
                                </li>
                            </div>

                            <div class="b-tab-content__item" role="tabpanel" v-if="currentTab === 'tab3'">
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Физика</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Химия</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Естествознание</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Основы экономики</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Правоведение</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Философия</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Экология</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Астрономия</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Риторика</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Физика</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Химия</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Естествознание</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Основы экономики</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Правоведение</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Философия</a>
                                </li>
                                <li class="b-type-tabs-item">
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Экология</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Астрономия</a>
                                    <a href="#" class="b-type-tabs-item__tab b-type-tabs-item__tab--hover">Риторика</a>
                                </li>
                            </div>

                    </nav>
                    </transition>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Tabs from '../RepeatComponents/Tab'

const TABS = [{
    title: 'Школьное образование',
    value: 'tab1',
    }, {
    title: 'Средне-специальное',
    value: 'tab2',
    }, {
    title: 'Высшее образование',
    value: 'tab3',
    }];

export default {
    components: { Tabs },
    data: () => ({
        tabs: TABS,
        currentTab: 'tab1',
        currentList: false
    }),
    methods: {
        handleClick(newTab) {
        this.currentTab = newTab;
        },

    }
}
</script>

<style lang="stylus">

@import '../../../stylus/_mixins.styl'
@import '../../../stylus/_rapture.styl'

rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

.b-type-education
    padding 50px 0px

.b-type-education__title
    position relative
    margin-bottom 30px
    padding-left 20px
    font-family "RobotoRegular", sans-serif
    font-size rem(20px)
    color #4B4B4B

.b-type-education__title--line
    &:before
        content ''
        position absolute
        top 0
        left 0
        width 4px
        height 100%
        background-color #4A69BD


.b-type-education-tabs
    width 100%
    display flex
    justify-content space-between
    margin-top 30px
    +below(lg)
        flex-wrap wrap

.b-type-education__items
    width 100%
    display flex
    justify-content space-between
    +below(lg)
        flex-direction column

.b-type-education__item
    display block
    width 90%
    padding 20px 15px 20px 30px
    border-radius 20px
    box-shadow: -2px 5px 36px -6px rgba(0,0,0,0.3)
    cursor pointer
    &:not(:last-child)
        margin-right 30px
    +below(lg)
        width 100%
        margin 0px 0px 30px 0px

.b-type-education__item--hover
    background #99AEDB
    color #fff
    cursor pointer
    transition all .25s ease
    &:hover
        background-color #99AEDB
        color #fff

.b-type-tabs-item
    display flex
    flex-direction column
    transition all .25s ease
    +below(lg)
        width 30%
    +below(md)
        width 50%
    +below(sm)
        width 40%


.b-type-tabs-item__tab
    position relative
    display inline-block
    padding 10px 0px
    font-family "RobotoLight"
    font-weight 400
    font-size rem(16px)
    color #000
    +below(md)
        font-size rem(14px)

.b-type-tabs-item__tab--hover
    transition all .25s ease
    &:hover
        transform translateY(-5px)
        color #99AEDB
        text-decoration none

.b-tab-content__item
    display flex
    justify-content space-between
    flex-wrap wrap
    +below(sm)
        justify-content center

.tabs__active-line
    display none

.b-tab-content__item
    width 100%
</style>
