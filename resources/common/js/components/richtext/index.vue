<template>
    <editor
        class="myeditablediv"
        api-key="n5vevbezoz59y0xm5lm9351k04wpcdlod46tt4h2ilw0x2er"
        v-model="editorData"
        :init="{
        selector: '.myeditablediv',
         height: 500,
         language: 'ru',
         menubar: 'file edit view insert format tools table help',
         plugins: [
           'preview importcss searchreplace autolink  directionality visualblocks visualchars fullscreen image link media  codesample table charmap pagebreak nonbreaking  insertdatetime advlist lists wordcount help charmap quickbars emoticons',
         ],
         toolbar:
           'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor  removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media'
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
