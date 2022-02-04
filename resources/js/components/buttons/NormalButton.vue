<template>
    <base-button
        :isActive="buttonIsActive"
        :isDisabled="mode != 'editor'"
        :clickMethod="toggleButton"
        :title="__(button)"
        :icon="icon"
        :innerHtml="innerHtml"
    >
    </base-button>
</template>

<script>

import BaseButton from './BaseButton.vue';

export default {
    props: ['button', 'editor', 'mode'],

    components: {
        BaseButton,
    },

    computed: {
         buttonIsActive() {
            if (!this.editor) {
                return false;
            }

            return this.editor.isActive(this.button);
        },

        icon() {
            if (this.button == 'bold') {
                return ['fas', 'bold'];
            } else if (this.button == 'italic') {
                return ['fas', 'italic'];
            } else if (this.button == 'highlight') {
                return ['fas', 'highlighter'];
            } else if (this.button == 'strike') {
                return ['fas', 'strikethrough'];
            } else if (this.button == 'underline') {
                return ['fas', 'underline'];
            } else if (this.button == 'blockquote') {
                return ['fas', 'quote-right'];
            } else if (this.button == 'bulletList') {
                return ['fas', 'list-ul'];
            } else if (this.button == 'orderedList') {
                return ['fas', 'list-ol'];
            } else if (this.button == 'horizontalRule') {
                return ['fas', 'horizontal-rule'];
            } else if (this.button == 'table') {
                return ['fas', 'table'];
            } else if (this.button == 'subscript') {
                return ['fas', 'subscript'];
            } else if (this.button == 'superscript') {
                return ['fas', 'superscript'];
            } else if (this.button == 'paragraph') {
                return ['fas', 'paragraph'];
            }

            return null;
        },

        innerHtml() {
            if (this.button == 'code') {
                return '<span> &lt;&gt; </span>';
            } else if (this.button == 'codeBlock') {
                return '<span> &lt;/&gt; </span>';
            } else if (this.button == 'hardBreak') {
                return '<span> BR </span>';
            }

            return null;
        }
    },

    methods: {
        toggleButton() {
            var command = this.editor.chain().focus();
            if (this.button == 'bold') {
                command.toggleBold();
            } else if (this.button == 'code') {
                command.toggleCode();
            } else if (this.button == 'italic') {
                command.toggleItalic();
            } else if (this.button == 'highlight') {
                command.toggleHighlight();
            } else if (this.button == 'strike') {
                command.toggleStrike();
            } else if (this.button == 'underline') {
                command.toggleUnderline();
            } else if (this.button == 'subscript') {
                command.toggleSubscript();
            } else if (this.button == 'superscript') {
                command.toggleSuperscript();
            } else if (this.button == 'blockquote') {
                command.toggleBlockquote();
            } else if (this.button == 'bulletList') {
                command.toggleBulletList();
            } else if (this.button == 'orderedList') {
                command.toggleOrderedList();
            } else if (this.button == 'codeBlock') {
                command.toggleCodeBlock();
            } else if (this.button == 'horizontalRule') {
                command.setHorizontalRule();
            } else if (this.button == 'table') {
                command.insertTable({ rows: 3, cols: 3, withHeaderRow: true });
            } else if (this.button == 'hardBreak') {
              command.setHardBreak();
            } else if (this.button == 'paragraph') {
              command.setParagraph();
            }

            command.run();
        }
    },
}
</script>
