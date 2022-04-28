<template>
    <div class="b-tab-questation">
        
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="b-breadcrumbs">
                        <div class="b-breadcrumbs__item">
                            Главная / Вопросы и ответы
                        </div>
                    </div>

                    <h1 class="tab-questation__title">Вопросы и ответы</h1>
                </div>
                <div class="col-12">
                    <div class="list-tab">
                        <tabs
                        :tabs="tabs"
                        :currentTab="currentTab"
                        :wrapper-class="'b-tab-questation'"
                        :tab-class="'b-tab-questation__item'"
                        :tab-active-class="'b-tab-questation__item_active'"
                        :line-class="'b-tab-questation__active-line'"
                        @onClick="handleClick"
                        />
                        <div class="b-tab-content" role="tablist">
                            <div class="b-tab-content__item" role="tabpanel" v-if="currentTab === 'tab1'">

                                <Accardion title="Начальное знакомство с матиматикой">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis explicabo porro, voluptatum laborum cumque molestiae quibusdam accusamus sed, quam sint ducimus libero distinctio? Dolore laborum, quos dolorem recusandae deleniti quasi.</p>
                                </Accardion>

                                <Accardion title="Начальное знакомство с матиматикой">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis explicabo porro, voluptatum laborum cumque molestiae quibusdam accusamus sed, quam sint ducimus libero distinctio? Dolore laborum, quos dolorem recusandae deleniti quasi.</p>
                                </Accardion>

                                <Accardion title="Параллельные прямые в пространстве">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis explicabo porro, voluptatum laborum cumque molestiae quibusdam accusamus sed, quam sint ducimus libero distinctio? Dolore laborum, quos dolorem recusandae deleniti quasi.</p>
                                </Accardion>

                            </div>
                            <div class="b-tab-content__item" role="tabpanel" v-if="currentTab === 'tab2'">

                                <Accardion title="Начальное знакомство с матиматикой">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis explicabo porro, voluptatum laborum cumque molestiae quibusdam accusamus sed, quam sint ducimus libero distinctio? Dolore laborum, quos dolorem recusandae deleniti quasi.</p>
                                </Accardion>

                                <Accardion title="Начальное знакомство с матиматикой">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis explicabo porro, voluptatum laborum cumque molestiae quibusdam accusamus sed, quam sint ducimus libero distinctio? Dolore laborum, quos dolorem recusandae deleniti quasi.</p>
                                </Accardion>

                                <Accardion title="Параллельные прямые в пространстве">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis explicabo porro, voluptatum laborum cumque molestiae quibusdam accusamus sed, quam sint ducimus libero distinctio? Dolore laborum, quos dolorem recusandae deleniti quasi.</p>
                                </Accardion>

                                <Accardion title="Параллельные прямые в пространстве">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis explicabo porro, voluptatum laborum cumque molestiae quibusdam accusamus sed, quam sint ducimus libero distinctio? Dolore laborum, quos dolorem recusandae deleniti quasi.</p>
                                </Accardion>

                            </div>
                            <div class="b-tab-content__item" role="tabpanel" v-if="currentTab === 'tab3'">

                                <Accardion title="Начальное знакомство с матиматикой">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis explicabo porro, voluptatum laborum cumque molestiae quibusdam accusamus sed, quam sint ducimus libero distinctio? Dolore laborum, quos dolorem recusandae deleniti quasi.</p>
                                </Accardion>

                                <Accardion title="Начальное знакомство с матиматикой">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis explicabo porro, voluptatum laborum cumque molestiae quibusdam accusamus sed, quam sint ducimus libero distinctio? Dolore laborum, quos dolorem recusandae deleniti quasi.</p>
                                </Accardion>

                                <Accardion title="Параллельные прямые в пространстве">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis explicabo porro, voluptatum laborum cumque molestiae quibusdam accusamus sed, quam sint ducimus libero distinctio? Dolore laborum, quos dolorem recusandae deleniti quasi.</p>
                                </Accardion>

                                <Accardion title="Параллельные прямые в пространстве">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis explicabo porro, voluptatum laborum cumque molestiae quibusdam accusamus sed, quam sint ducimus libero distinctio? Dolore laborum, quos dolorem recusandae deleniti quasi.</p>
                                </Accardion>

                            </div>
                        </div>

                        <div class="form-wrap">
                            <h2 class="form-questation__title">
                                Не нашли ответ на вопрос?
                            </h2>
                            <form class="form-questation">
                                <div class="form-questation-sec form-questation-sec--line">
                                    <input class="form-questation-sec__input" type="text" id="email-questation" placeholder="E-mail">
                                    <input class="form-questation-sec__input" type="text" id="name-questation" placeholder="Имя">
                                </div>
                                <div class="form-questation-sec  form-questation-sec--group">
                                    <textarea class="form-questation-sec__textarea" name="message" id="questation-message"></textarea>
                                    <button type="submit" class="form-questation-btn">Отправить</button>
                                </div>
                                <div class="form-questation-alert">
                                    <p>
                                        <span>*</span> Пожалуйста войдите по своим аккаунтом, или зарегистрируйтесь
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Tabs from '../RepeatComponents/Tab'
import Accardion from '../RepeatComponents/AccordionItem'

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
    metaInfo: {
        title: 'Онлайн обучение - Вопросы и ответы',
    },
    components: {
        Tabs,
        Accardion
    },
    data: () => ({
        tabs: TABS,
        currentTab: 'tab1',
        currentList: false
    }),
    methods: {
        handleClick(newTab) {
        this.currentTab = newTab;
        },

    },
    }
</script>

<style lang="stylus">

@import '../../../assets/style/_mixins'
@import '../../../assets/style/_rapture'
rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

.b-breadcrumbs
    margin 50px 0px 30px 0px
    font-family 'RobotoLight'
    font-size 16px
    font-weight 400
    color #9F9F9F

.tab-questation__title
    font-family 'RobotoRegular', sans-serif
    font-size rem(36px)
    color #4B4B4B
    +below(md)
        font-size rem(26px)

.list-tab
    margin-bottom 40px

.b-tab-questation 
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
            margin-bottom 20px
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

.questation-item
    &:first-child
        margin-top 40px

.questation-main
    position relative
    width 100%
    display flex
    justify-content space-between
    align-items center
    margin-top 20px
    padding 30px 20px
    border-radius 15px
    box-shadow 0px 9px 75px -25px rgba(0,0,0,0.42)
    background-color #fff
    cursor pointer


.questation-item--open
    .questation-main
        background-color #EBEBEB
        box-shadow none
    .questation-main__svg
        transform rotate(180deg)

.questation-main__title
    margin 0
    line-height 1
    font-family 'RobotoRegular'
    font-size: 18px
    font-weight: 400
    color #4B4B4B

.questation-main__svg
    width 20px
    height 20px


.questation-sub
    width 100%
    display flex
    justify-content space-between
    align-items center
    margin-top 10px
    padding 30px 40px
    border 2px dashed #E1E1E1
    border-radius 15px
    box-shadow 0px 9px 75px -25px rgba(0,0,0,0.42)
    cursor pointer


.questation-sub--open
    .questation-main__svg
        transform rotate(180deg)

.questation-sub__title
    margin 0
    line-height 1
    font-family 'RobotoItalic'
    font-size: 18px
    font-weight: 400
    color #4B4B4B

.questation-sub__svg
    width 20px
    height 20px

.form-questation
    margin-bottom 80px

.form-questation__title
    margin 60px 0px 40px 0px
    font-family 'OpenSansSemiRegular', sans-serif
    font-size rem(28px)
    color #4B4B4B

.form-questation-sec
    width 100%

.form-questation-sec--line
    display flex
    justify-content space-between
    align-self auto
    +below(sm)
        flex-direction column
        flex-wrap wrap

.form-questation-sec--group
    position relative
    margin-top 20px
    +below(sm)
        display flex
        flex-direction column
        align-items center

.form-questation-sec__input
    width 48%
    height 55px
    padding 0px 20px
    border 1px solid #E2E2E2
    border-radius 10px
    &::placeholder
        color #000
    +below(sm)
        width 100%
        &:first-child
            margin-bottom 20px

.form-questation-sec__textarea
    width 100%
    min-height 100px
    border 1px dashed #A7A7A7
    border-radius 10px
    resize none
    +below(md)
        height 150px

.form-questation-btn
    position absolute
    top calc(50% - 24px)
    right 30px
    padding 10px 40px
    border none
    border-radius 30px
    background-color #6A89CC
    font-family "RubikRegular"
    color #fff
    transition: background-color .25s ease
    &:hover
        background-color #5A79BC
    +below(md)
        position static
        width 200px
        margin-top 15px
        

.form-questation-alert
    margin-top 20px
    font-family "RobotoRegular"
    color #FC4924

</style>
