<template>
    <section class="mb-4">
        <h4>Для кого</h4>
        <el-button class="mb-4" icon="el-icon-plus" type="primary" @click="addItem">Добавить элемент</el-button>
        <draggable v-model="localList" class="row" tag="div" @end="endSort">
            <item
                :item="item"
                v-for="(item, index) in localList"
                :key="index"
                @delete="deleteItem"
            ></item>
        </draggable>
        <el-dialog
            title="Новый элемент"
            :visible.sync="modalVisible"
            width="80%"
            append-to-body
        >
            <create @submit="createItem" v-if="modalVisible"></create>
        </el-dialog>
    </section>
</template>
<script>
import Item from './item'
import draggable from 'vuedraggable';
import Create from "./create";
import Vue from 'vue';
export default {
    props: {
        list: {
            type: Array,
            required:true
        },
        delete_img: {
            type: Array,
        }
    },
    components: { Item, Create, draggable },
    data() {
        return {
            localList:this.list,
            modalVisible:false,
        }
    },
    methods: {
        endSort(){
            this.$emit('sort', {list:this.localList, list_name:'banners'})
        },
        deleteItem(index) {
            if(this.localList[index].image.id) {
                this.delete_img.push(this.localList[index].image.id)
            }
            this.localList.splice(index,1);
        },
        createItem(data) {
            this.localList.push(data);
            this.modalVisible = false;
        },
        addItem() {
            this.modalVisible = true;
        },

    },
    created() {
        let vm = this;
        Vue.nextTick(function () {
            vm.localList = vm.list;
        });
    }
}
</script>
