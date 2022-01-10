<template>
    <span class="whitespace-nowrap">
        <base-button
            :isActive="rtlIsActive()"
            :isDisabled="mode != 'editor'"
            :clickMethod="setRtl"
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
        setRtl() {
            const okNodes = [
                'paragraph', 'heading'
            ];

            if (this.rtlIsActive()) {
                okNodes.forEach(
                    nodename => this.editor.chain().focus().updateAttributes(nodename, { dir: 'ltr' }).run()
                );
                 
            } else {
                okNodes.forEach(
                    nodename => this.editor.chain().focus().updateAttributes(nodename, { dir: 'rtl' }).run()
                );
            }
        }
    }
}

</script>
