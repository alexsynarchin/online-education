<template>
    <section class="mb-4">
        <h3 class="tarif-title">Все цифры указаны с учетом комиссии системы — 15%</h3>
        <div class="b-table-transac">
            <div class="b-table-transac__head">
                <div class="b-table-transac__head_item b-table-transac__head_item--count">
                    Сумма
                </div>
                <div class="b-table-transac__head_item b-table-transac__head_item--des">
                    Описание
                </div>
                <div class="b-table-transac__head_item b-table-transac__head_item--date">
                    Дата
                </div>
            </div>
            <div class="b-table-transac__body">
                <div class="b-table-transac__item" v-for="(item, index) in withdraws" :key="index">
                    <div class="b-table-transac__item_count">-{{item.sum}} руб. </div>
                    <div class="b-table-transac__item_des">Вывод средств</div>
                    <div class="b-table-transac__item_date">{{item.formatted_created_at}}</div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    data() {
        return {
            withdraws: [],
        }
    },
    methods: {
        getWithdraws() {
            axios.get('/api/profile/withdraw/list')
                .then((response) => {
                    this.withdraws = response.data;
                })
        },
    },
    mounted() {
        this.getWithdraws();
    }
}
</script>
