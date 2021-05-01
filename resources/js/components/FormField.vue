<template>
    
    <default-field 
        :field="field"
        :errors="errors"
        :full-width-content="true"
        :show-help-text="showHelpText"
    >
        <template slot="field">
            <div
                class=""
            >
                <template>
                    <div class="flex items-center">
                        <div 
                            v-for="button in buttons" 
                            :key="'button-'+button"
                        >
                            
                            <template v-if="button == 'heading'">
                                <heading-buttons
                                    :headingLevels="headingLevels"
                                    :editor="editor"
                                >
                                </heading-buttons>
                            </template>

                            <template v-else>
                                <normal-button
                                    :editor="editor"
                                    :button="button"
                                >
                                </normal-button>
                            </template>
                        </div>
                    </div>
                </template>
                
            </div>
            <div class="
                nova-tiptap-editor
                mt-4
                form-input-bordered w-full
                pt-2 pb-2
            ">
                <div 
                    :class="'js-nova-tiptap-editor-'+field.attribute"
                    :id="field.attribute"
                ></div>
            </div>
        </template>
    </default-field>
    
</template>

<script>

import { Editor } from '@tiptap/core';
import HardBreak from '@tiptap/extension-hard-break';
import Text from '@tiptap/extension-text';
import Bold from '@tiptap/extension-bold';
import Heading from '@tiptap/extension-heading';
import Document from '@tiptap/extension-document';
import Paragraph from '@tiptap/extension-paragraph';
import NormalButton from './buttons/NormalButton';
import HeadingButtons from './buttons/HeadingButtons';
import { FormField, HandlesValidationErrors } from 'laravel-nova';

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    components: {
        NormalButton,
        HeadingButtons,
    },

    data() {
        return {
            editor: null,
        }
    },

    computed: {
        buttons() {
            return this.field.buttons ? this.field.buttons : ['bold', 'italic'];
        },

        headingLevels() {
            return this.field.headingLevels ? this.field.headingLevels : [1, 2, 3];
        }
    },

    mounted() {
        console.log(this.headingLevels);
        console.log(this.buttons);


        this.editor = new Editor({
            element: document.getElementsByClassName('js-nova-tiptap-editor-'+this.field.attribute)[0],
            extensions: [
                HardBreak,
                Document,
                Paragraph,
                Text,
                Bold,
                Heading.configure({
                    levels: this.headingLevels,
                }),
            ],
            content: this.field.value,
             onUpdate({ editor }) {
                this.field.value = editor.content;
            }
        });
    },


    beforeDestroy() {
        this.editor.destroy()
    },
}
</script>

<style lang="scss">
.nova-tiptap-editor {
    padding-bottom: 20px;
    padding-top: 20px;

    .ProseMirror-focused {
        outline: none;
    }

    p, h1, h2, h3, h4, h5, h6, blockquote, ul, ol, table, li {
        margin-top: 1em;
    }

    p:first-child, 
    h1:first-child, 
    h2:first-child, 
    h3:first-child, 
    h4:first-child, 
    h5:first-child, 
    h6:first-child, 
    blockquote:first-child, 
    ul:first-child, 
    ol:first-child, 
    table:first-child, 
    li:first-child {
        margin-top: 0;
    }
}
</style>
