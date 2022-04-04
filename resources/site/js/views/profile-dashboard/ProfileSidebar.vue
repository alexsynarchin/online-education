<template>
    <div class="d-none d-lg-block col-lg-3">
    <aside class="b-aside-teachers">
        <nav class="nav-profile">
            <li class="nav-profile__item">
                <svg class="nav-profile__icon">
                    <use xlink:href="/images/sprite.svg#home"></use>
                </svg>
                <a href="/profile" class="nav-profile__link">Мой профиль</a>
            </li>
        </nav>
        <ul class="b-my-data" v-if="user.profile_type=='teacher'">
            <li class="b-my-data__item" style="padding-bottom: 0">
                <i class="el-icon-plus b-my-data__icon" style="color:#6a89cc; font-size: 20px"></i>
                <a href="/profile/course/create" class="b-my-data__link">Создать курс</a>
            </li>
            <li class="b-my-data__item" style="padding-bottom: 0">
                <svg class="b-my-data__icon">
                    <use xlink:href="/images/sprite.svg#srednee_obrazovanie"></use>
                </svg>
                <a href="/profile/my-courses/active" class="b-my-data__link">Мои курсы</a>
            </li>
            <li class="b-my-data__item b-my-data__item--sub" v-for="(tab, index) in tabs" :class="{'b-my-data__item--last': index === 3}">
                <a :href="'/profile/my-courses/' + tab.type" class="b-my-data__link b-my-data__link--sub">{{tab.title}} ({{tab.count}})</a>
            </li>
            <li class="b-my-data__item">
                <svg class="b-my-data__icon">
                    <use xlink:href="/images/sprite.svg#login"></use>
                </svg>
                <a href="/profile/students" class="b-my-data__link">Мои ученики</a>
            </li>

        </ul>
        <ul class="b-my-data" v-if="user.profile_type=='student'">
            <li class="b-my-data__item">
                <svg class="b-my-data__icon">
                    <use xlink:href="/images/sprite.svg#srednee_obrazovanie"></use>
                </svg>
                <a href="/profile/education" class="b-my-data__link">Мои курсы</a>
            </li>
            <li class="b-my-data__item">
                <svg class="b-my-data__icon">
                    <use xlink:href="/images/sprite.svg#login"></use>
                </svg>
                <a href="/profile/teachers" class="b-my-data__link">Мои преподаватели</a>
            </li>
            <li class="b-my-data__item">
                <svg class="b-my-data__icon">
                    <use xlink:href="/images/sprite.svg#list"></use>
                </svg>
                <a href="/profile/tests" class="b-my-data__link">Мои Тесты</a>
            </li>
        </ul>
        <ul class="b-my-notification">
            <li class="b-my-notification__item">
                <svg class="b-my-notification__icon">
                    <use xlink:href="/images/sprite.svg#mail"></use>
                </svg>
                <a href="/profile/messages" class="b-my-notification__link">Сообщения</a>
            </li>
            <li class="b-my-notification__item">
                <svg class="b-my-notification__icon">
                    <use xlink:href="/images/sprite.svg#zvonok"></use>
                </svg>
                <a href="/profile/notifications" class="b-my-notification__link">Уведомления</a>
            </li>
            <li class="b-my-notification__item">
                <svg class="b-my-notification__icon">
                    <use xlink:href="/images/sprite.svg#ruble"></use>
                </svg>
                <a class="b-my-notification__link" href="/profile/transactions">Транзакции</a>
            </li>
        </ul>

        <div class="my-count">
            <span class="my-count__text" v-if="user.profile_type==='teacher'">На счету:</span>
            <span class="my-count__text" v-if="user.profile_type==='student'">Бонусы:</span>
            <span class="my-count__check">{{balance}}</span>
            <span class="my-count__ruble" v-if="user.profile_type==='teacher'">руб</span>
        </div>
        <button class="btn button" @click="addPromo" v-if="user.profile_type==='student'" style="width: 100%; margin-top: 15px">
            Активировать промокод
        </button>
    </aside>
</div>
</template>

<script>
import EventBus from "../../EventBus";

export default {
    props :['user'],
    mounted(){
        this.getBalance();
        this.getCoursesCount();
    },
    data(){
        return{
            balance: 0,
            tabs:[],
        }
    },
    methods:{
        addPromo() {
            EventBus.$emit('show-promo-modal');
        },
        getBalance(){
            axios.get('/api/sidebar-balance')
                .then((response)=>{
                    console.log(response.data)
                    this.balance = response.data
                })
                .catch((error)=>{

                });
        },
        getCoursesCount() {
            axios.get('/api/profile/course/count', {params:{
                    statuses: [2,1,0,3]
                }})
                .then((response) => {
                    this.tabs = response.data;
                })
        },
    }
}
</script>

<style lang="stylus" scoped>

@import '../../../stylus/_mixins.styl'

.b-aside-teachers
    margin 50px 0px
    border 1px dashed #D1D1D1
    border-radius 10px

.nav-profile
    border-bottom 1px dashed #D1D1D1

.nav-profile__item
    display flex
    align-items center
    padding 10px 20px
    list-style-type none
    &:first-child
        position relative
        margin-bottom 5px

.nav-profile__icon
    position relative
    top -1px
    display inline-block
    size 22px
    margin-right 10px
    fill #6a89cc

.nav-profile__link
    display block
    padding 8px 0px
    font 400 rem(17px) 'RobotoRegular',sans-serif
    color #4B4B4B

.b-my-data
    padding 10px 0px
    border-bottom 1px dashed #D1D1D1

.b-my-data__item
    display flex
    align-items center
    padding 5px 20px
    list-style-type none
.b-my-data__item--sub
    margin-left 30px
    padding 0 20px
.b-my-data__item--last
    margin-bottom:5px
.b-my-data__icon
    position relative
    top -1px
    display inline-block
    size 22px
    margin-right 10px
    fill #6a89cc

.b-my-data__link
    display block
    padding 8px 0px
    font 400 rem(17px) 'Raleway',sans-serif
    color #4B4B4B
.b-my-data__link--sub
    color rgba(39, 39, 39, 0.5)
    padding 4px 0
.b-my-notification
    padding-left 0
.b-my-notification__item
    display flex
    align-items center
    padding 5px 20px
    list-style-type none


.b-my-notification__icon
    position relative
    top -1px
    display inline-block
    size 22px
    margin-right 10px
    fill #6a89cc

.b-my-notification__link
    display block
    padding 8px 0px
    font 400 rem(17px) 'RobotoRegular',sans-serif
    color #4B4B4B

.my-count
    padding 10px 20px
    background-color #99AEDB
    border-radius 10px
    font 400 rem(17px) 'RobotoRegular',sans-serif
    color #fff

.my-count__text
    margin-right 5px

.my-count__ruble
    margin-left 5px
</style>

