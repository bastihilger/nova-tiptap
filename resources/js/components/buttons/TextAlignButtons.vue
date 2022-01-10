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
            :icon="['fas', 'align-'+iconName(alignment)]"
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
        iconName(alignment) {
            if (alignment == 'start') { return 'left' };
            if (alignment == 'end') { return 'right' };
            return alignment;
        }, 
        alignmentIsActive(alignment) {
            let isActive = this.editor ? this.editor.isActive({ textAlign: alignment }) : false;
            if (alignment == 'left') {
                isActive = this.editor 
                    ? (this.editor.isActive({ textAlign: 'left' }) || this.editor.isActive({ textAlign: 'start' })) 
                    : false
            }
            if (alignment == 'right') {
                isActive = this.editor 
                    ? (this.editor.isActive({ textAlign: 'right' }) || this.editor.isActive({ textAlign: 'end' })) 
                    : false
            }
           return isActive;
        },
        setAlignment(alignment) {
            if (alignment == 'left') {
                alignment = 'start';
            }
            if (alignment == 'right') {
                alignment = 'end';
            }
            this.editor.chain().focus().setTextAlign(alignment).run();
        }
    }
}

</script>
