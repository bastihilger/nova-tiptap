<template>
    <span class="whitespace-nowrap">
        <button
            v-for="alignment in alignments"
            :key="'alignment-button'+alignment"
            type="button"
            class="
                btn btn-default p-1 m-1
                leading-none text-xs
                min-w-8 mr-1 h-8
                tiptap-button
            "
            :class="{ 
                'btn-primary': editor ? editor.isActive({ textAlign: alignment }) : false,
                'bg-white hover:bg-20': editor ? !editor.isActive({ textAlign: alignment }) : true,
                'opacity-50 pointer-events-none': mode != 'editor',
            }"
            @click="editor.chain().focus().setTextAlign(alignment).run()"
        >
          <font-awesome-icon :icon="['fas', 'align-'+alignment]">
            </font-awesome-icon>
        </button>
    </span>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core';

import {
    faAlignLeft,
    faAlignRight,
    faAlignCenter,
    faAlignJustify
} from '@fortawesome/free-solid-svg-icons';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(
    faAlignLeft,
    faAlignRight,
    faAlignCenter,
    faAlignJustify
);

export default {
    props: ['alignments', 'alignElements', 'defaultAlignment', 'editor', 'mode'],

    components: {
        FontAwesomeIcon,
    },
}

</script>
