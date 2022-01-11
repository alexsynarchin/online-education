<template>
    <div class="social-auth__wrap">

        <h3 class="modal-form-group__title mt-4 mb-2 text-center">Войти, используя аккаунт в соцсети</h3>
        <ul class="social-auth">
            <li class="social-auth__item">
                <a href="#" class="social-auth__link" @click.prevent="handleSocialAuth('vkontakte')">
                    <img src="/images/social/vk_2.png">
                </a>
            </li>
            <li class="social-auth__item">
                <a href="#" @click.prevent="handleSocialAuth('odnoklassniki')" class="social-auth__link">
                    <img src="/images/social/odnoklassniki.png">
                </a>
            </li>
            <li class="social-auth__item">
                <a href="#" @click.prevent="handleSocialAuth('facebook')" class="social-auth__link">
                    <img src="/images/social/facebook.png">
                </a>
            </li>
        </ul>
    </div>
</template>
<script>
    export default {
        props:['profile_type', 'url'],
        methods: {
            handleSocialAuth(type) {
                window.location.href = '/api/social-auth/' + type +'?profile_type='+this.profile_type + '&url=' + this.url ;
            }
        }
    }
</script>
