<template>
    <section class="mb-4">
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
                <div class="b-table-transac__item" v-for="(item, index) in orders" :key="index">
                    <div class="b-table-transac__item_count">-{{item.sum}} руб. </div>
                    <div class="b-table-transac__item_des"> Покупка <template v-if="item.type==='course'">курса</template>
                        <template v-else>урока</template> "{{item.name}}"</div>
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
            orders: [],
        }
    },
    methods: {
        getOrders() {
            axios.get('/api/profile/orders')
                .then((response) => {
                    this.orders = response.data;
                })
        },
    },
    mounted() {
        this.getOrders();
    }
}
</script>
