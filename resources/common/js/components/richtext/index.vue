<template>
    <editor
        api-key="n5vevbezoz59y0xm5lm9351k04wpcdlod46tt4h2ilw0x2er"
        v-model="editorData"
        :init="{
         height: 500,
         menubar: false,
         plugins: [
           'advlist autolink lists link image charmap print preview anchor',
           'searchreplace visualblocks code fullscreen',
           'insertdatetime media table paste code help wordcount'
         ],
         toolbar:
           'undo redo | formatselect | bold italic backcolor | \
           alignleft aligncenter alignright alignjustify | \
           bullist numlist outdent indent | removeformat | help'
       }"
    />
</template>
<script>
import Editor from '@tinymce/tinymce-vue'

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
        'editor': Editor
    },
    data() {
        return {
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

            }
        }
    }
}
</script>
