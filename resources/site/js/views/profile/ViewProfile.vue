<template>
    <section>
        <div class="profile-user">
            <div class="profile-user-avatar">
                <div class="profile-user-avatar__content">
                    <img class="profile-user-avatar__img"  :alt="user.name + ' ' +  user.surname" :src="user.avatar" id="profile-pic">
                    <div class="profile-user-avatar__fullname">
                        {{user.name}}
                        {{user.surname}}
                    </div>
                </div>
            </div>
            <a class="profile-user-edit" href="#">
                <svg class="profile-user-edit__icon">
                    <use xlink:href="/images/sprite.svg#pencil-edit"></use>
                </svg>
                <span class="profile-user-edit__text" @click.prevent="handleEdit">Редактировать</span>
            </a>

            <div class="profile-user-transac" v-if="user.profile_type === 'student'">
                <el-button type="primary" @click.prevent="$modal.show('AddStudentPromoModal')">Введите промокод</el-button>
            </div>
            <div class="profile-user-transac" v-if="user.profile_type === 'teacher'">
                <div class="profile-user-count">
                    <svg class="profile-user-count__icon">
                        <use xlink:href="/images/sprite.svg#ruble"></use>
                    </svg>
                    <div class="profile-user-text">
                        <span class="profile-user-text">На счету:</span>
                        <span class="profile-user-text__score">0</span>
                        <span class="profile-user-text__currency">Руб</span>
                    </div>
                    <div class="profile-user-questation">
                        <svg class="profile-user-questation__icon">
                            <use xlink:href="/images/sprite.svg#question"></use>
                        </svg>
                        <span class="profile-user-questation__popup">
                                    На денежные средства на странице баланса применяется комиссия в размере 15%
                                </span>
                    </div>
                </div>
                <a class="profile-user-withdraw" href="/profile/transactions">
                    <svg class="profile-user-withdraw__icon">
                        <use xlink:href="/images/sprite.svg#download"></use>
                    </svg>
                    <span class="profile-user-withdraw__text">Вывести</span>
                </a>
            </div>
        </div>
        <div class="profile-data">
            <div class="profile-data-item">
                <div class="profile-data-head">
                    Общие данные
                </div>
                <div class="profile-data-body">
                    <div class="profile-data-body__item">
                        <span class="profile-data-text__left">Тип профиля:</span>
                        <span class="profile-data-text__right">{{profile_type}}</span>
                    </div>
                    <div class="profile-data-body__item">
                        <span class="profile-data-text__left">ID</span>
                        <span class="profile-data-text__right">{{user.id}}</span>
                    </div>
                    <div class="profile-data-body__item">
                        <span class="profile-data-text__left">Дата регистрации:</span>
                        <span class="profile-data-text__right">{{user.formatted_created_at}}</span>
                    </div>
                    <div class="profile-data-body__item">
                        <span class="profile-data-text__left">Уведомления:</span>
                        <span class="profile-data-text__right">включены</span>
                    </div>
                </div>
            </div>
            <div class="profile-data-item">
                <div class="profile-data-head">
                    Данные пользователя
                </div>
                <div class="profile-data-body">
                    <div class="profile-data-body__item">
                        <span class="profile-data-text__left">Пол:</span>
                        <span class="profile-data-text__right">{{user.gender_string}}</span>
                    </div>
                    <div class="profile-data-body__item">
                        <span class="profile-data-text__left">Дата рождения</span>
                        <span class="profile-data-text__right">{{user.formatted_birthday}}</span>
                    </div>
                    <div class="profile-data-body__item">
                        <span class="profile-data-text__left">Город</span>
                        <span class="profile-data-text__right">{{user.city}}</span>
                    </div>
                </div>
            </div>
            <div class="profile-data-item">
                <div class="profile-data-head">
                    Контакты
                </div>
                <div class="profile-data-body">
                    <div class="profile-data-body__item">
                        <span class="profile-data-text__left">E-mail</span>
                        <span class="profile-data-text__right">{{user.email}}</span>
                    </div>
                    <div class="profile-data-body__item">
                        <span class="profile-data-text__left">Телефон</span>
                        <span class="profile-data-text__right">{{user.phone}}</span>
                    </div>
                </div>
            </div>
            <div class="profile-data-item" v-if="user.profile_type === 'teacher'">
                <div class="profile-data-head">
                    Опыт работы
                </div>
                <ul class="mt-2 nb-2">
                    <li
                    v-for="(item, index) in user.edu_institutions "
                    >
                        {{item.title}}
                    </li>
                </ul>
            </div>
        </div>
        <add-student-promo></add-student-promo>
    </section>

</template>
<script>
    import AddStudentPromo from "./AddStudentPromo";
export  default {
    components:{
        'AddStudentPromo':AddStudentPromo,
    },
    props:['user','account'],
    computed:{
        profile_type:function () {
            let profile_type;
            switch (this.user.profile_type) {
                case 'teacher':
                    profile_type = 'Преподаватель';
                    break;
                case 'student':
                    profile_type = 'Учащийся';
                    break;
                default:
                    profile_type = '';
                    break;
            }
            return profile_type;
        },
    },
    data() {
        return {

        }
    },
    methods:{
        handleEdit() {
            this.$emit('handleEdit')
        }
    },
    mounted() {

    }
}
</script>
