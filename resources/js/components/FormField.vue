<template>
    <default-field :field="field" :errors="errors" :fullWidthContent="true">
        <template slot="field">

            <editor-menu-bar :editor="editor">
                <div class="menubar" slot-scope="{ commands, isActive, getMarkAttrs }">
                    <template v-for="(buttonKey, params) in buttons">
                        <template v-if="buttonKey == 'heading' || params == 'heading'">
                            <heading-buttons
                                :headingLevels="headingLevels"
                                :commands="commands"
                                :isActive="isActive"
                            >
                            </heading-buttons>
                        </template>

                        <template v-if="buttonKey != 'heading' && buttonKey != 'link' && params != 'heading'">
                            <normal-button
                                :buttonKey="buttonKey"
                                :commands="commands"
                                :isActive="isActive"
                            >
                            </normal-button>
                        </template>

                        <span class="tiptap-button-container" v-if="buttonKey == 'link'">
                            <link-button
                                :commands="commands"
                                :isActive="isActive"
                                :linkMenuIsActive="linkMenuIsActive"
                                :linkUrl="linkUrl"
                                :hideLinkMenu="hideLinkMenu"
                                :showLinkMenu="showLinkMenu"
                                :getMarkAttrs="getMarkAttrs"
                                :setLinkUrl="setLinkUrl"
                            >
                            </link-button>
                        </span>

                    </template>
                  </div>
            </editor-menu-bar>

            <editor-content
                class="
                tiptap-content
                py-3 h-auto
                pr-6
                pb-4
                pt-4
                w-full
                form-control
                form-input
                form-input-bordered
                mt-2
                no-focus
                "
                :editor="editor"
            />
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import { Editor, EditorContent, EditorMenuBar, EditorMenuBubble } from 'tiptap'
import HeadingButtons from './buttons/HeadingButtons';
import NormalButton from './buttons/NormalButton';
import LinkButton from './buttons/LinkButton';

import {
    Blockquote,
    CodeBlock,
    HardBreak,
    Heading,
    OrderedList,
    BulletList,
    HorizontalRule,
    ListItem,
    TodoItem,
    TodoList,
    Bold,
    Code,
    Italic,
    Link,
    Strike,
    Underline,
    History,
} from 'tiptap-extensions'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    components: {
        EditorContent,
        EditorMenuBar,
        HeadingButtons,
        NormalButton,
        LinkButton,
    },

    data: function () {
        return {
            headingLevels: 3,

            linkUrl: null,

            linkMenuIsActive: false,

            editor: new Editor({
                extensions: [
                    new Blockquote(),
                    new BulletList(),
                    new CodeBlock(),
                    new HardBreak(),
                    new Heading({ levels: [1, 2, 3] }),
                    new HorizontalRule(),
                    new ListItem(),
                    new OrderedList(),
                    new TodoItem(),
                    new TodoList(),
                    new Bold(),
                    new Code(),
                    new Italic(),
                    new Link(),
                    new Strike(),
                    new Underline(),
                    new History(),
                ],
            }),
        }
    },

    computed: {
        buttons() {
            return this.field.buttons ? this.field.buttons : ['bold', 'italic'];
        }
    },

    methods: {
        initEditor() {
            this.editor.setContent(this.value);

            // set the value each time editor is updated
            let outsideScope = this;
            this.editor.setOptions({
                onUpdate: function (state) {
                    outsideScope.value = state.getHTML();
                }
            });

            // set heading levels
            if (this.field.headingLevels) {
                this.headingLevels = this.field.headingLevels;
            } else {
                // fallback for the old style like this: 'heading' => 4
                _.forEach(this.buttons, function(params, key) {
                    if (key == 'heading') {
                        this.headingLevels = params;
                    }
                }.bind(this));
            }

        },

        showLinkMenu(attrs) {
            this.linkUrl = attrs.href;
            this.linkMenuIsActive = true;
        },

        hideLinkMenu() {
            this.linkUrl = null;
            this.linkMenuIsActive = false;
        },

        setLinkUrl(command, url) {
            command({ href: url });
            this.hideLinkMenu();
            this.editor.focus();
        },
    },

    mounted: function () {
        this.initEditor();
    }
}
</script>

<style>
.tiptap-content {
    outline: none !important;
    box-shadow: none !important;
}

.ProseMirror:focus {
    outline: none;
}

.ProseMirror ins {
    text-decoration: none;
    background-color: highlight;
}

.ProseMirror p, ul, ol, blockquote, pre {
    margin-bottom: 1em;
}

.ProseMirror h1, .ProseMirror h2, .ProseMirror h3, .ProseMirror h4, .ProseMirror h5, .ProseMirror h6 {
    margin-bottom: 0.5em;
}

.ProseMirror pre {
    white-space: pre-line;
}

.ProseMirror blockquote {
    border-left: 4px solid var(--60);
    padding-left: 12px;
    margin-left: 0;
    font-style: italic;
}

.ProseMirror p:last-child {
    margin-bottom: 0;
}

.tiptap-button {
    box-sizing: border-box;
    vertical-align: top;
    margin-right: 8px;
    font-weight: 400;
}

.tiptap-button-container {
    position: relative;
    overflow: visible;
}

.tiptap-button-form {
    position: absolute;
    top: 36px;
    left: -130px;
    display: flex;
    background-color: white;
    align-items: center;
}

.tiptap-button-form .form-input {
    width: 180px;
    margin-right: 20px;
    color: black;
}

.tiptap-button-form .btn {
    width: 16px;
    height: 16px;
}


.tiptap-button::before {
    margin: 0;
    height: 16px;
    line-height: 0;
    position: relative;
}

.tiptap-button.is-bold::before {
    content: 'B';
}

.tiptap-button.is-italic::before {
    font-style: italic;
    content: 'I';
}

.tiptap-button.is-strike::before {
    text-decoration: line-through;
    content: 'S';
}

.tiptap-button.is-underline::before {
    text-decoration: underline;
    content: 'U';
}

.tiptap-button.is-code::before {
    content: '<>';
}

.tiptap-button.is-code_block::before {
    content: '</>';
}




</style>
