<template>
    <span class="whitespace-nowrap">
        <base-button
            :isActive="rtlIsActive()"
            :isDisabled="mode != 'editor'"
            :clickMethod="toggleRtl"
            :title="'RTL'"
            :icon="['fas', 'paragraph-rtl']"
        >
        </base-button>
    </span>
</template>

<script>

import BaseButton from './BaseButton.vue';

export default {
    props: ['alignments', 'alignElements', 'defaultAlignment', 'editor', 'mode'],

    components: {
        BaseButton,
    },

    methods: {
        rtlIsActive() {
           return this.editor ? this.editor.isActive({ dir: 'rtl' }) : false;
        },
        toggleRtl() {
            if (this.rtlIsActive()) {
                this.editor.chain().focus().updateAttributes('paragraph', { dir: 'auto' }).run();
            } else {
                this.editor.chain().focus().updateAttributes('paragraph', { dir: 'rtl' }).run();
                this.editor.chain().focus().updateAttributes('heading', { dir: 'rtl' }).run();
            }
            
        }
    }
}

</script>
