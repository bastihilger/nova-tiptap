<template>
  <button
        type="button"
        class="
            group relative
            btn btn-default
            p-2 m-1
            leading-none text-xs
            min-w-8 h-8 
            tiptap-button
        "
        :class="{ 
            'btn-primary': isActive,
            'bg-white hover:bg-20': !isActive,
            'opacity-50 pointer-events-none': isDisabled,
        }"
        @click="callClickMethod"
    >
        <div 
            class="
                transition-opacity opacity-0 group-hover:opacity-100 pointer-events-none
                absolute left-0 bottom-9 w-full flex justify-center z-100
            "
        >
            <div 
                v-html="title"
                class="
                    whitespace-nowrap bg-black 
                    text-2xs text-white font-semibold capitalize
                    px-1 py-px rounded
                "
            >

            </div>
        </div>

        <template v-if="icon">
            <font-awesome-icon :icon="icon">
            </font-awesome-icon>
        </template>

        <template v-else>
            <span v-html="innerHtml"></span>
        </template>
    </button>
</template>

<script>

import { library } from '@fortawesome/fontawesome-svg-core';

import {
    faHorizontalRule,
    faParagraphRtl,
    faImagePolaroid
} from '@fortawesome/pro-solid-svg-icons';

import {
    faCube
} from '@fortawesome/pro-regular-svg-icons';

import { 
    faAlignCenter,
    faAlignJustify,
    faAlignLeft,
    faAlignRight,
    faBold,
    faCode,
    faCubes,
    faFileCode,
    faHighlighter,
    faImage,
    faItalic,
    faLink, 
    faListOl,
    faListUl,
    faParagraph,
    faQuoteRight,
    faRedoAlt,
    faStrikethrough,
    faSubscript,
    faSuperscript,
    faTable,
    faUnderline,
    faUndoAlt,
    faUnlink
} from '@fortawesome/free-solid-svg-icons';

library.add(
    faAlignCenter,
    faAlignJustify,
    faAlignLeft,
    faAlignRight,
    faBold,
    faCode,
    faCube,
    faCubes,
    faFileCode,
    faHighlighter,
    faHorizontalRule,
    faImage,
    faImagePolaroid,
    faItalic,
    faLink, 
    faListOl,
    faListUl,
    faParagraph,
    faParagraphRtl,
    faQuoteRight,
    faRedoAlt,
    faStrikethrough,
    faSubscript,
    faSuperscript,
    faTable,
    faUnderline,
    faUndoAlt,
    faUnlink
);

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

export default {
    props: [
        'clickMethod', 
        'clickMethodParameters',
        'title',
        'isActive',
        'isDisabled',
        'icon',
        'innerHtml',
    ],

    components: {
        FontAwesomeIcon,
    },

    methods: {
        callClickMethod() {
            if (this.clickMethodParameters) {
                if (!typeof(this.clickMethodParameters) != 'object') {
                    this.clickMethodParameters = [this.clickMethodParameters];
                }

                this.clickMethod(...this.clickMethodParameters);
            } else {
                this.clickMethod();
            }
        }
    }
}
</script>
