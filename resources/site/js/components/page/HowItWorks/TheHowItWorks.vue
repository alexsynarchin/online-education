<template>


                <div class="col-12">
                    <div class="list-tab">
                        <tabs
                        :tabs="tabs"
                        :currentTab="currentTab"
                        :wrapper-class="'b-tab-how-work'"
                        :tab-class="'b-tab-how-work__item'"
                        :tab-active-class="'b-tab-how-work__item_active'"
                        :line-class="'b-tab-how-work__active-line'"
                        @onClick="handleClick"
                        />

                        <div class="b-tab-content" role="tablist">
                            <div class="b-tab-content__item" role="tabpanel" v-if="currentTab === 'tab1'">
                                <div class="b-tab-block">
                                    <h2 class="b-tab-block__title">Регистрация</h2>
                                    <img class="b-tab-block__img" src="/images/reg.png" alt="">
                                    <div class="b-tab-block__text">
                                        <p>
                                            Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...
                                        </p>
                                    </div>
                                </div>

                                <div class="b-tab-block">
                                    <h2 class="b-tab-block__title">Регистрация</h2>
                                    <img class="b-tab-block__img" src="/images/reg.png" alt="">
                                    <div class="b-tab-block__text">
                                        <p>
                                            Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...
                                        </p>
                                    </div>
                                </div>

                                <div class="b-tab-block">
                                    <h2 class="b-tab-block__title">Регистрация</h2>
                                    <img class="b-tab-block__img" src="/images/novost_3.jpg" alt="">
                                    <div class="b-tab-block__text">
                                        <p>
                                            Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="b-tab-content__item" role="tabpanel" v-if="currentTab === 'tab2'">
                                <div class="b-tab-block">
                                    <h2 class="b-tab-block__title">Регистрация</h2>
                                    <img class="b-tab-block__img" src="/images/novost_3.jpg" alt="">
                                    <div class="b-tab-block__text">
                                        <p>
                                            Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="b-tab-content__item" role="tabpanel" v-if="currentTab === 'tab3'">
                                <div class="b-tab-block">
                                    <h2 class="b-tab-block__title">Регистрация</h2>
                                    <img class="b-tab-block__img" src="/images/novost_2.jpg" alt="">
                                    <div class="b-tab-block__text">
                                        <p>
                                            Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...Здравствуйте. Подскажите в чём может быть проблема  чём может быть  чём мож ...
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
</template>

<script>
import Tabs from '../../RepeatComponents/Tab'

const TABS = [{
    title: 'Ученикам',
    value: 'tab1',
    }, {
    title: 'Преподавателям',
    value: 'tab2',
    }, {
    title: 'Доп.Образование',
    value: 'tab3',
    }];

export default {
    components: {
        Tabs
    },
    data: () => ({
        tabs: TABS,
        currentTab: 'tab1',
    }),
    methods: {
        handleClick(newTab) {
        this.currentTab = newTab;
        },
    },
    }
</script>

<style lang="stylus">

@import '../../../../stylus/_mixins.styl'
@import '../../../../stylus/_rapture.styl'
rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

.b-how-work__title
    font-family 'OpenSansSemiBold', sans-serif
    font-size rem(36px)
    color #4B4B4B
    +below(md)
        font-size rem(26px)

.list-tab
    margin-bottom 40px

.b-tab-how-work
    position: relative
    margin: 0 auto
    margin-top 30px
    +below(md)
        display flex
        flex-direction column
        justify-content flex-start

    &__item
        display: inline-block
        margin: 0 30px
        padding-bottom: 2px
        font-family 'RobotoRegular'
        font-size: 16px
        font-weight: 400
        letter-spacing: 0.8px
        color: #000
        text-decoration: none
        border: none
        background-color: transparent
        border-bottom: 2px solid transparent
        cursor: pointer
        transition: all 0.25s
        +below(md)
            margin-bottom 10px
            margin-left 0px
        &:first-child
            margin-left: 0
            padding-left 0

        &:last-child
            margin-right: 0
        &_active
            font-family 'RobotoMedium'
            color: #000
    &__active-line
        position: absolute
        bottom: 0
        left: 0
        height: 2px
        background-color: #4A69BD
        transition: transform 0.4s ease, width 0.4s ease
        +below(md)
            display none

.content
    margin-top: 30px
    font-size: 20px

.b-tab-content__item
    transition: all 1s ease

.b-tab-block
    margin 80px 0px

.b-tab-block__title
    font-family 'RubikRegular', sans-serif
    font-size rem(28px)
    color #4B4B4B

.b-tab-block__img
    width 100%
    object-fit cover
    border-radius 15px

.b-tab-block__text
    margin-top 20px
    font-family 'RobotoRegular', sans-serif
    font-size rem(16px)
    color #4B4B4B

</style>
