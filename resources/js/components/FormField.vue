<template>
    <default-field 
        :field="field"
        :errors="errors"
        :full-width-content="true"
        :show-help-text="showHelpText"
    >
        <template slot="field">
            <div
                class="
                    w-full sticky overflow-break top-3 z-10
                    bg-40 rounded-lg
                "
            >
                <template>
                    <div class="p-1">
                        <div 
                            v-for="button in buttons" 
                            :key="'button-'+button"
                            :class="{
                                'inline-block': button != 'br'
                            }"
                        >
                            <template v-if="button == '|'">
                                <button class="
                                    w-px h-6 relative top-2 mx-1
                                    bg-60
                                ">
                                     
                                </button>
                            </template>

                            <template v-else-if="button == 'br'">
                            </template>

                            <template v-else-if="button == 'heading'">
                                <heading-buttons
                                    :headingLevels="headingLevels"
                                    :mode="mode"
                                    :editor="editor"
                                >
                                </heading-buttons>
                            </template>

                            <template v-else-if="button == 'link'">
                                <link-button
                                    :editor="editor"
                                    :button="button"
                                    :field="field"
                                    :mode="mode"
                                    :fileDisk="fileDisk"
                                    :filePath="filePath"
                                >
                                </link-button>
                            </template>

                            <template v-else-if="button == 'image'">
                                <image-button
                                    :editor="editor"
                                    :button="button"
                                    :field="field"
                                    :mode="mode"
                                    :imageDisk="imageDisk"
                                    :imagePath="imagePath"
                                >
                                </image-button>
                            </template>

                            <template v-else-if="button == 'placeholderBlock'">
                                <placeholder-block-button
                                    :editor="editor"
                                    :button="button"
                                    :field="field"
                                    :mode="mode"
                                >
                                </placeholder-block-button>
                            </template>

                            <template v-else-if="button == 'contentBlock'">
                                <content-block-button
                                    :editor="editor"
                                    :button="button"
                                    :field="field"
                                    :mode="mode"
                                    :imageDisk="imageDisk"
                                    :imagePath="imagePath"
                                >
                                </content-block-button>
                            </template>

                            <template v-else-if="button == 'textAlign'">
                                <text-align-buttons
                                    :editor="editor"
                                    :mode="mode"
                                    :alignments="alignments"
                                    :alignElements="alignElements"
                                    :defaultAlignment="defaultAlignment"
                                >
                                </text-align-buttons>
                            </template>

                            <template v-else-if="button == 'rtl'">
                                <rtl-button
                                    :editor="editor"
                                    :mode="mode"
                                >
                                </rtl-button>
                            </template>

                            <template v-else-if="button == 'history'">
                                <history-buttons
                                    :editor="editor"
                                    :mode="mode"
                                >
                                </history-buttons>
                            </template>

                            <template v-else-if="button == 'editHtml'">
                                <base-button
                                    :isActive="mode == 'html'"
                                    :clickMethod="switchMode"
                                    :icon="['fas', 'file-code']"
                                    :title="__('edit html')"
                                >
                                    
                                </base-button>
                                
                            </template>

                            <template v-else>
                                <normal-button
                                    :editor="editor"
                                    :button="button"
                                    :mode="mode"
                                >
                                </normal-button>
                            </template>
                        </div>
                    </div>

                    <div 
                        class="flex items-center z-10"
                        v-if="tableIsActive"
                    >
                        <table-buttons
                            :editor="editor"
                        >
                        </table-buttons>
                    </div>
                </template>
            </div>

            <div 
                class="
                    nova-tiptap-editor
                    mt-4
                    form-input-bordered w-full
                    pt-2 pb-2
                "
                :style="cssProps"
                v-show="mode == 'editor'"
                
            >
                <editor-content :editor="editor" />
            </div>

            <div 
                class="
                    mt-4
                    w-full px-0
                "
                v-show="mode == 'html'"
            >
                <edit-html :updateMethod="updateValueFromHtml" :theme="htmlTheme" v-model="htmlModeValue" />
            </div>
        </template>
    </default-field>
</template>

<script>
import { Editor, EditorContent, VueNodeViewRenderer } from '@tiptap/vue-2';

import Text from '@tiptap/extension-text';

import Blockquote from '@tiptap/extension-blockquote';
import Bold from '@tiptap/extension-bold';
import BulletList from '@tiptap/extension-bullet-list';
import Code from '@tiptap/extension-code';
import CodeBlock from '@tiptap/extension-code-block';
import CodeBlockLowlight from '@tiptap/extension-code-block-lowlight';
import Highlight from '@tiptap/extension-highlight';
import HorizontalRule from '@tiptap/extension-horizontal-rule';
import Italic from '@tiptap/extension-italic';
import Link from '@tiptap/extension-link';
import ListItem from '@tiptap/extension-list-item';
import OrderedList from '@tiptap/extension-ordered-list';
import Strike from '@tiptap/extension-strike';
import Subscript from '@tiptap/extension-subscript';
import Superscript from '@tiptap/extension-superscript';
import TextStyle from '@tiptap/extension-text-style';
import Underline from '@tiptap/extension-underline';

import Heading from '@tiptap/extension-heading';
import TextAlign from '@tiptap/extension-text-align';
import History from '@tiptap/extension-history';
import Document from '@tiptap/extension-document';

import Table from '@tiptap/extension-table';
import TableRow from '@tiptap/extension-table-row';
import TableCell from '@tiptap/extension-table-cell';
import TableHeader from '@tiptap/extension-table-header';

import Paragraph from '@tiptap/extension-paragraph';
import HardBreak from '@tiptap/extension-hard-break';
import Placeholder from '@tiptap/extension-placeholder';

import Image from '@tiptap/extension-image';
import Dropcursor from '@tiptap/extension-dropcursor';

import LinkButton from './buttons/LinkButton';
import NormalButton from './buttons/NormalButton';
import HeadingButtons from './buttons/HeadingButtons';
import TableButtons from './buttons/TableButtons';
import TextAlignButtons from './buttons/TextAlignButtons';
import RtlButton from './buttons/RtlButton';
import HistoryButtons from './buttons/HistoryButtons';
import ImageButton from './buttons/ImageButton';
import PlaceholderBlockButton from './buttons/PlaceholderBlockButton';
import ContentBlockButton from './buttons/ContentBlockButton';
import BaseButton from './buttons/BaseButton.vue';

import CodeBlockComponent from './CodeBlockComponent';
import EditHtml from './EditHtml';

import Gapcursor from '@tiptap/extension-gapcursor';

import lowlight from 'lowlight';
import pretty from 'pretty';

import buttonHovers from '../mixins/buttonHovers';

import { FormField, HandlesValidationErrors } from 'laravel-nova';

import PlaceholderBlockExtension from '../extensions/PlaceholderBlockExtension.js';
import VideoContentBlockExtension from './content-blocks/VideoContentBlockExtension.js';
import GalleryContentBlockExtension from './content-blocks/GalleryContentBlockExtension.js';

export default {
    mixins: [FormField, HandlesValidationErrors, buttonHovers],

    props: ['resourceName', 'resourceId', 'field'],

    components: {
        EditorContent,
        LinkButton,
        NormalButton,
        HeadingButtons,
        TableButtons,
        TextAlignButtons,
        RtlButton,
        HistoryButtons,
        ImageButton,
        PlaceholderBlockButton,
        ContentBlockButton,
        EditHtml,
        BaseButton,
    },

    data() {
        return {
            editor: null,
            mode: 'editor',
            htmlModeValue: '',
            placeholder: '',
            imageDisk: '',
            imagePath: '',
            fileDisk: '',
            filePath: '',
        }
    },

    watch: {
        htmlModeValue: function (val) {
            this.editor.commands.setContent(val);
            this.updateValue(this.editor.getHTML());
        }
    },

    computed: {
        contentWithTrailingParagraph() {
            
            if (_.isString(this.value) && _.endsWith(_.trim(this.value), 'content-block>')) {
                return this.value+'<p></p>';
            }

            return this.value;
        },
        buttons() {
            let tmpButtons = this.field.buttons ? this.field.buttons : ['bold', 'italic'];  
            
            return _.map(tmpButtons, function(button){
                return button == '|' || button == 'br' ? button : _.camelCase(button);
            });
        },

        headingLevels() {
            return this.field.headingLevels ? this.field.headingLevels : [1, 2, 3];
        },

        alignments() {
            return this.field.alignments ? this.field.alignments : ['start', 'center', 'end', 'justify'];
        },

        alignElements() {
            return this.field.alignElements ? this.field.alignElements : ['heading', 'paragraph'];
        },

        defaultAlignment() {
            return this.field.defaultAlignment ? this.field.defaultAlignment : 'left';
        },

        cssProps() {
            return {
                '--text-align': this.defaultAlignment
            }
        },

        htmlTheme() {
            return this.field.htmlTheme ? this.field.htmlTheme : 'material';
        },

        tableIsActive() {
           if(this.buttons.indexOf('table') > -1) {
               return this.editor ? this.editor.isActive('table') : false;
           }
           return false;
        },

        saveAsJson() {
            return this.field.saveAsJson ? this.field.saveAsJson : false;
        }
    },

    methods: {
        updateValue(value) {
            this.value = value;
        },

        switchMode() {
            if (this.mode == 'html') {
                this.editor.commands.setContent(this.htmlModeValue);
                this.updateValue(this.editor.getHTML());
                this.mode = 'editor';
            } else {
                this.htmlModeValue = pretty(this.editor.getHTML());
                this.mode = 'html';
            }
        },
    },

    mounted() {
        this.placeholder = this.field.placeholder ? this.field.placeholder 
                         : (this.field.extraAttributes ? this.field.extraAttributes.placeholder : '');

        if (this.field.imageSettings && this.field.imageSettings.path) {
            this.imagePath = this.field.imageSettings.path;
        }
        if (this.field.imageSettings && this.field.imageSettings.disk) {
            this.imageDisk = this.field.imageSettings.disk;
        }
        if (this.field.fileSettings && this.field.fileSettings.path) {
            this.filePath = this.field.fileSettings.path;
        }
        if (this.field.fileSettings && this.field.fileSettings.disk) {
            this.fileDisk = this.field.fileSettings.disk;
        }

        let extensions = [
            Document,
            Bold,
            Code,
            Italic,
            Highlight,
            PlaceholderBlockExtension.extend({
                addAttributes() {
                    return {
                        ...this.parent?.(),
                        'data-key': {
                            default: 'bogus',
                        },
                    }
                },
            }),
            VideoContentBlockExtension,
            GalleryContentBlockExtension,
            Link.extend({
                addAttributes() {
                    return {
                        ...this.parent?.(),
                        'tt-mode': {
                            default: 'url',
                        },
                        class: String,
                        rel: String,
                        title: String,
                        download: String,
                    }
                }
            }),
            Strike,
            TextStyle,
            Underline,
            Subscript,
            Superscript,
            
            Heading.configure({
                levels: this.headingLevels,
            }).extend({
                addAttributes() {
                    return {
                        ...this.parent?.(),
                        dir: String,
                    }
                }
            }),
            Blockquote.extend({
                addAttributes() {
                    return {
                        ...this.parent?.(),
                        dir: String,
                    }
                }
            }),
            BulletList.extend({
                addAttributes() {
                    return {
                        ...this.parent?.(),
                        dir: String,
                    }
                }
            }),
            HorizontalRule,
            ListItem,    
            OrderedList.extend({
                addAttributes() {
                    return {
                        ...this.parent?.(),
                        dir: String,
                    }
                }
            }),
            HardBreak,
            Paragraph.extend({
                addAttributes() {
                    return {
                        ...this.parent?.(),
                        dir: String,
                        data: String,
                    }
                }
            }),
            Table.configure({
                resizable: true,
            }),
            TableRow,
            TableCell,
            TableHeader,
            TextAlign.configure({
                types: this.alignElements,
                alignments: this.alignments,
                defaultAlignment: this.defaultAlignment,
            }),
            History,
            Text,
            Gapcursor,
            Placeholder.configure({
                placeholder: this.placeholder,
            }),
            Image.extend({
                addAttributes() {
                    return {
                        ...this.parent?.(),
                        'tt-mode': {
                            default: 'file',
                        },
                        'tt-link-url': {
                            default: '',
                        },
                        'tt-link-target': {
                            default: '',
                        },
                        'tt-link-mode': {
                            default: 'url',
                        },
                        class: String,
                        title: String,
                        alt: String,
                    }
                }
            }),
            Dropcursor,
        ];

        if (this.buttons.includes('codeBlock') && this.field.syntaxHighlighting) {
            extensions.push(
                CodeBlockLowlight
                .extend({
                    addNodeView() {
                        return VueNodeViewRenderer(CodeBlockComponent)
                    },
                })
                .configure({
                    lowlight,
                })
            );
        } else if(this.buttons.includes('codeBlock')) {
            extensions.push(CodeBlock);
        }

        const context = this;

        this.editor = new Editor({
            extensions: extensions,
            content: this.contentWithTrailingParagraph,
            onCreate() {
                try {
                    let content = JSON.parse(context.value);
                    this.commands.setContent(content);
                } catch {} 
            },
            onUpdate() {
                if (context.saveAsJson) {
                    let jsonContent = this.getJSON();
                    context.updateValue(JSON.stringify(jsonContent.content));
                } else {
                    context.updateValue(this.getHTML());
                }
            },
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

    img.ProseMirror-selectednode {
        outline: 3px solid var(--primary-30);
    }

    .ProseMirror {
        p.is-editor-empty:first-child::before {
            content: attr(data-placeholder);
            float: left;
            color: #ced4da;
            pointer-events: none;
            height: 0;
        }

        p, h1, h2, h3, h4, h5, h6, blockquote, ul, ol, table, pre {
            margin-top: 1em;
            line-height: 1.5em;
        }

        p, h1, h2, h3, h4, h5, h6 {
            text-align: var(--text-align);
        }

        pre {
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 12px;
            padding-right: 12px;
            background-color: var(--90);
            color: white;
            border-radius: .125rem;
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
        pre:first-child {
            margin-top: 0;
        }

        blockquote {
            display: block;
            margin-top: 1.5em;
            margin-bottom: 1.5em;
            padding-left: 15px;
            border-left: 3px solid #dddddd;
        }
        
        a {
            pointer-events: none;
        }

        hr {
            border-top: 1px solid var(--80);
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .tableWrapper {
            margin-top: 15px;
            overflow-x: auto;
        }

        .resize-cursor {
            cursor: ew-resize;
            cursor: col-resize;
        }

        table {
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
            overflow: hidden;

            td,
            th {
                min-width: 1em;
                border: 2px solid var(--90);
                padding: 3px 5px;
                vertical-align: top;
                box-sizing: border-box;
                position: relative;

                > * {
                    margin-bottom: 0;
                }
            }

            th {
                font-weight: bold;
                text-align: left;
                background-color: #f1f3f5;
            }

            .selectedCell:after {
                z-index: 2;
                position: absolute;
                content: "";
                left: 0; right: 0; top: 0; bottom: 0;
                background: rgba(200, 200, 255, 0.4);
                pointer-events: none;
            }

            .column-resize-handle {
                position: absolute;
                right: -2px;
                top: 0;
                bottom: -2px;
                width: 4px;
                background-color: #adf;
                pointer-events: none;
            }
        }
    }
}
</style>
