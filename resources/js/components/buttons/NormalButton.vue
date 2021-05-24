<template>
    <button
        :title="button"
        type="button"
        class="
            btn btn-default p-1 leading-none
            text-xs min-w-8 h-8 m-1 tiptap-button
        "
        :class="[
            (mode != 'editor' ? 'opacity-50 pointer-events-none' : ''),
            (buttonIsActive() ? 'btn-primary' : 'bg-white hover:bg-20'),
            'is-' + button
        ]"
        @click="toggleButton()"
    >
        <font-awesome-icon v-if="button == 'bold'" :icon="['fas', 'bold']">
        </font-awesome-icon>

        <span v-if="button == 'code'"> &lt;&gt; </span>

        <font-awesome-icon v-if="button == 'italic'" :icon="['fas', 'italic']">
        </font-awesome-icon>

        <font-awesome-icon v-if="button == 'highlight'" :icon="['fas', 'highlighter']">
        </font-awesome-icon>

        <font-awesome-icon v-if="button == 'strike'" :icon="['fas', 'strikethrough']">
        </font-awesome-icon>

        <font-awesome-icon v-if="button == 'underline'" :icon="['fas', 'underline']">
        </font-awesome-icon>

        <font-awesome-icon v-if="button == 'bulletList'" :icon="['fas', 'list-ul']">
        </font-awesome-icon>

        <font-awesome-icon v-if="button == 'orderedList'" :icon="['fas', 'list-ol']">
        </font-awesome-icon>

        <font-awesome-icon v-if="button == 'blockquote'" :icon="['fas', 'quote-right']">
        </font-awesome-icon>

        <font-awesome-icon v-if="button == 'horizontalRule'" :icon="['fas', 'horizontal-rule']">
        </font-awesome-icon>

        <font-awesome-icon v-if="button == 'table'" :icon="['fas', 'table']">
        </font-awesome-icon>

        <span v-if="button == 'codeBlock'"> &lt;/&gt; </span>

        <span v-if="button == 'superscript'">
            x<small><sup>2</sup></small>
        </span>

        <span v-if="button == 'subscript'">
            x<small><sub>2</sub></small>
        </span>
    </button>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core';

import {
    faHorizontalRule
} from '@fortawesome/pro-solid-svg-icons';

import {
    faBold,
    faCode,
    faHighlighter,
    faItalic,
    faStrikethrough,
    faListUl,
    faListOl,
    faQuoteRight,
    faUnderline,
    faTable
} from '@fortawesome/free-solid-svg-icons';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(
    faBold,
    faCode,
    faItalic,
    faHighlighter,
    faStrikethrough,
    faUnderline,
    faListUl,
    faListOl,
    faQuoteRight,
    faHorizontalRule,
    faTable
);


export default {
    props: ['button', 'editor', 'mode'],

    components: {
        FontAwesomeIcon,
    },

    computed: {
        tiptapButtonName() {
            return this.button;
        }
    },

    methods: {
        buttonIsActive() {
            if (!this.editor) {
                return false;
            }
            
            return this.editor.isActive(this.tiptapButtonName);
        },

        toggleButton() {
            var command = this.editor.chain().focus();
            if (this.tiptapButtonName == 'bold') {
                command.toggleBold();
            } else if (this.tiptapButtonName == 'code') {
                command.toggleCode();
            } else if (this.tiptapButtonName == 'italic') {
                command.toggleItalic();
            } else if (this.tiptapButtonName == 'highlight') {
                command.toggleHighlight();
            } else if (this.tiptapButtonName == 'strike') {
                command.toggleStrike();
            } else if (this.tiptapButtonName == 'underline') {
                command.toggleUnderline();
            } else if (this.tiptapButtonName == 'blockquote') {
                command.toggleBlockquote();
            } else if (this.tiptapButtonName == 'bulletList') {
                command.toggleBulletList();
            } else if (this.tiptapButtonName == 'orderedList') {
                command.toggleOrderedList();
            } else if (this.tiptapButtonName == 'codeBlock') {
                command.toggleCodeBlock();
            } else if (this.tiptapButtonName == 'horizontalRule') {
                command.setHorizontalRule();
            } else if (this.tiptapButtonName == 'table') {
                command.insertTable({ rows: 3, cols: 3, withHeaderRow: true });
            }

            command.run();
        }
    },
}
</script>
