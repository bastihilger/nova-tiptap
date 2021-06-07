<template>
    <span class="whitespace-nowrap">
        <base-button
            v-for="alignment in alignments"
            :key="'alignment-button'+alignment"
            :isActive="alignmentIsActive(alignment)"
            :isDisabled="mode != 'editor'"
            :clickMethod="setAlignment"
            :clickMethodParameters="alignment"
            :title="__('align '+alignment)"
            :icon="['fas', 'align-'+alignment]"
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
        alignmentIsActive(alignment) {
           return this.editor ? this.editor.isActive({ textAlign: alignment }) : false;
        },
        setAlignment(alignment) {
            this.editor.chain().focus().setTextAlign(alignment).run();
        }
    }
}

</script>
