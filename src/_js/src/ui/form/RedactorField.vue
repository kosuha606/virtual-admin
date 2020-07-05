<template>
    <div>
        <label for="">
            {{ label }}
        </label>
        <ckeditor id="redactor" :config="editorConfig" :editor="editor" v-model="content"></ckeditor>
    </div>
</template>

<script>
    import CKEditor from '@ckeditor/ckeditor5-vue';
    import Editor from '../../ckeditor5/build/ckeditor';
    import {clone} from 'lodash';

    export default {
        name: "RedactorField",
        props: ['value', 'label', 'props'],
        components: {
            ckeditor: CKEditor.component,
        },
        created() {
            console.log('test');
            if (this.value) {
                this.content = clone(this.value);
            }
        },
        watch: {
            content(value) {
                this.$emit('input', value);
            }
        },
        data() {
            return {
                content: '',
                editor: Editor,
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
                            'codeBlock',
                            'fontBackgroundColor',
                            'fontColor',
                            'horizontalLine',
                            'code',
                            'alignment',
                            'insertTable',
                            'mediaEmbed',
                            'undo',
                            'redo'
                        ]
                    },
                    language: 'ru',
                    image: {
                        toolbar: [
                            'imageTextAlternative',
                            'imageStyle:full',
                            'imageStyle:side'
                        ]
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells'
                        ]
                    },
                    licenseKey: '',
                    ckfinder: {
                        uploadName: 'test',
                        uploadUrl: '/file/ckeditor'
                    },
                    style: {
                        minHeight: '300px'
                    },
                    language: 'ru'
                }
            }
        },
    }
</script>

<style scoped>
</style>