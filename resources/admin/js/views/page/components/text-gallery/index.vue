<template>
    <section>
        {{blocks}}
        <el-button class="mb-4" icon="el-icon-plus" type="primary" @click="addItem">Добавить Блок</el-button>
        <draggable v-model="localBlocks" class="row" tag="div" @end="endSort">
            <item
                :item="item"
                v-for="(item, index) in localBlocks"
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
    import Vue from "vue";
    import create from "./create";
    import item from "./item";
    import draggable from 'vuedraggable';
    export default {
        components: {
            create, item, draggable,
        },
        props: {
            blocks: {
                type: Array
            },
            delete_img: {
                type: Array,
            }
        },
        data() {
            return {
                localBlocks:this.blocks,
                modalVisible:false,
            }
        },
        methods: {
            deleteItem() {

            },
            endSort(){
                this.$emit('sort', {list:this.localBlocks, list_name:'instruction'})
            },
            createItem(data) {
                this.localBlocks.push(data);
                this.modalVisible = false;
            },
            addItem() {
                this.modalVisible = true;
            },
        },
        created() {
            let vm = this;
            Vue.nextTick(function () {
                vm.localBlocks = vm.blocks;
            });
        }
    }
</script>
