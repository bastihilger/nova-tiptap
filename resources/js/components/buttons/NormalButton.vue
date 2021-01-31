<template>
    <button
        type="button"
        class="
            btn
            btn-default
            p-2
            leading-none
            text-xs
            min-w-8
            h-8
            tiptap-button
        "
        :class="[
            (buttonIsActive() ? 'btn-primary' : ''),
            'is-' + button
        ]"
        @click="toggleButton()"
    >
        <font-awesome-icon v-if="button == 'bold'" :icon="['fas', 'bold']">
        </font-awesome-icon>

        <font-awesome-icon v-if="button == 'bullet_list'" :icon="['fas', 'list-ul']">
        </font-awesome-icon>

        <font-awesome-icon v-if="button == 'ordered_list'" :icon="['fas', 'list-ol']">
        </font-awesome-icon>

        <font-awesome-icon v-if="button == 'blockquote'" :icon="['fas', 'quote-right']">
        </font-awesome-icon>

        <font-awesome-icon v-if="button == 'edit_html'" :icon="['fas', 'file-code']">
        </font-awesome-icon>

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
    faBold,
    faCode,
    faListUl,
    faListOl,
    faQuoteRight,
    faFileCode
} from '@fortawesome/free-solid-svg-icons';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(
    faBold,
    faCode,
    faListUl,
    faListOl,
    faQuoteRight,
    faFileCode
);


export default {
    props: ['button', 'editor'],

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
            }

            command.run();
        }
    },
}
</script>
