<template>
    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
</template>
<script>
import CkeEditor from "@ckeditor/ckeditor5-vue2";
import ClassicEditor from 'ckeditor5-karta-metrov-build/build/ckeditor';
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
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'indent',
                        'outdent',
                        '|',
                        'imageUpload',
                        'blockQuote',
                        'insertTable',
                        'mediaEmbed',
                        'undo',
                        'redo'
                    ]
                },
                image: {
                    resizeUnit: 'px',
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:full',

                        'imageStyle:alignLeft',
                        'imageStyle:alignRight'
                    ],
                    styles: [
                        // This option is equal to a situation where no style is applied.
                        'full',

                        // This represents an image aligned to the left.
                        'alignLeft',

                        // This represents an image aligned to the right.
                        'alignRight'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                },
                language: 'ru'
            }
        }
    }
}
</script>
