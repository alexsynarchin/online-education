<template>
    <div>
        <div class="tabs">
            <ul class="nav b-tab">
                <li v-for="tab in tabs" class="b-tab__title nav-item">
                    <a :href="tab.href" @click.prevent="selectTab(tab)" class="b-tab__link nav-link" :class="{ 'active': tab.isActive }" >
                        {{ tab.name }}
                    </a>
                </li>
            </ul>
        </div>

        <div class="tabs-details b-tab__item">
            <slot></slot>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {tabs: [] };
        },

        created() {

            this.tabs = this.$children;

        },
        methods: {
            selectTab(selectedTab) {
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.name === selectedTab.name);
                });
            }
        }
    }
</script>
