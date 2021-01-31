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
            <div 
                class="nova-tiptap-editor"
                :id="'nova-tiptap-editor-'+field.attribute"
            ></div>
        </template>
    </default-field>
    
</template>

<script>

import { Editor } from '@tiptap/core';
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
            element: document.getElementById('nova-tiptap-editor-'+this.field.attribute),
            extensions: [
                Document,
                Paragraph,
                Text,
                Bold,
                Heading.configure({
                    levels: this.headingLevels,
                }),
            ],
            content: '<p>Your content.</p>',
        });
    },


    beforeDestroy() {
        this.editor.destroy()
    },
}
</script>

<style>

</style>
