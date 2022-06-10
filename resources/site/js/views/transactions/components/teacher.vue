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
                <div class="b-table-transac__item" v-for="(item, index) in withdraws" :key="index">
                    <div class="b-table-transac__item_count"
                        :class="{
                        'b-table-transac__item_count--danger':!item.done
                        }"
                    >-{{item.sum}} руб. </div>
                    <div class="b-table-transac__item_des">
                        Вывод средств
                        (<template v-if="item.done">Одобрено</template><template v-else>Ждет одобрения</template>)
                    </div>
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
