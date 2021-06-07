<template>
    <span class="whitespace-nowrap">
        <base-button
            v-for="direction in ['undo', 'redo']"
            :key="'history-button'+direction"
            :isDisabled="mode != 'editor'"
            :clickMethod="changeHistory"
            :clickMethodParameters="direction"
            :title="__(direction)"
            :icon="['fas', direction+'-alt']"
        >
        </base-button>
    </span>
</template>

<script>

import BaseButton from './BaseButton.vue';

export default {
    props: ['editor', 'mode'],

    components: {
        BaseButton,
    },

    methods: {
        changeHistory(direction) {
            direction == 'undo' 
                ? this.editor.chain().focus().undo().run() 
                : this.editor.chain().focus().redo().run();
        }
    }
}

</script>
