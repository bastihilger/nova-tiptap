<template>
    <span class="whitespace-nowrap">
        <base-button
            v-for="level in headingLevels" 
            :key="'heading-button'+level"
            :isActive="headingIsActive(level)"
            :isDisabled="mode != 'editor'"
            :clickMethod="setHeading"
            :clickMethodParameters="level"
            :title="__('heading :level', {'level': level})"
            :innerHtml="'H'+level"
        >
        </base-button>
    </span>
</template>

<script>

import BaseButton from './BaseButton.vue';

export default {
    props: ['headingLevels', 'editor', 'mode'],

    components: {
        BaseButton,
    },

    methods: {
        headingIsActive(level) {
           return this.editor ? this.editor.isActive('heading', { level: level }) : false;
        },
        setHeading(level) {
            this.editor ? this.editor.chain().focus().toggleHeading({ level: level }).run() : null
        },
    }
}

</script>
