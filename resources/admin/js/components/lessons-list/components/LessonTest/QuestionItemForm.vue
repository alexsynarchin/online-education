<template>
    <el-form label-position="top" :model="value" ref="question_item" :rules="rules">
        <el-row type="flex" :gutter="15">
            <el-form-item prop="preview" label="Изображение обложки">
                <el-upload
                    action=""
                    v-model="value.preview"
                    class="avatar-uploader"
                    :auto-upload="false"
                    :show-file-list="false"
                    :on-change="onFileChange"
                >
                    <img v-if="value.preview" :src="value.preview" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
            </el-form-item>
            <el-form-item  label="Текст вопроса" prop="text" style="flex:  auto; margin-left: 1rem">
                <richtext v-model="value.text"></richtext>
            </el-form-item>
        </el-row>
    </el-form>
</template>
<script>
import richtext from "@/common/js/components/richtext";
    export default {
        components: {
            richtext,
        },
        props: {
            value: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                rules: {

                }
            }
        },
        methods: {
            updateValue(key, value) {
                this.$emit("input", { ...this.value, [key]: value });
            },
            onFileChange(file) {
                let cond = this.beforeImageUpload(file.raw);
                console.log(cond);
                if(cond){
                    this.createImage(file);
                }
            },
            beforeImageUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isPNG = file.type === 'image/png';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isJPG && !isPNG) {
                    this.$message.error('Картинка должна быть в формате jpeg или png');
                }
                if (!isLt2M) {
                    this.$message.error('Размер не может превышать 2МБ');
                }
                return (isJPG || isPNG) && isLt2M;
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.question.preview = e.target.result;
                };
                reader.readAsDataURL(file.raw);
            },
        }
    }
</script>
