<template>
    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
</template>
<script>
import CkeEditor from "@ckeditor/ckeditor5-vue2";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import '@ckeditor/ckeditor5-build-classic/build/translations/ru';
    export default {
        model: {
            prop: 'text',
            event: 'change'
        },
        props: {
            text: String,
        },
        watch: {
            editorData: function (val) {
                console.log(val);
                this.$emit('change',val);
            }
        },
        components: {
            ckeditor: CkeEditor.component
        },
        data() {
            return {
                editor:ClassicEditor,
                editorData:this.text,
                editorConfig: {
                    language: 'ru'
                }
            }
        }
    }
</script>
