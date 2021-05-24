<template>
    <span class="whitespace-nowrap">
        <button
            v-for="direction in ['undo', 'redo']"
            :key="'history-button'+direction"
            type="button"
            class="
                btn btn-default p-1 m-1
                leading-none text-xs
                min-w-8 mr-1 h-8
                tiptap-button
                bg-white hover:bg-20
            "
            :class="{ 
                'opacity-50 pointer-events-none': mode != 'editor',
            }"
            @click="
                direction == 'undo' 
                ? editor.chain().focus().undo().run() 
                : editor.chain().focus().redo().run()
            "
        >
          <font-awesome-icon :icon="['fas', direction+'-alt']">
            </font-awesome-icon>
        </button>
    </span>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core';

import {
    faUndoAlt,
    faRedoAlt
} from '@fortawesome/free-solid-svg-icons';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(
    faUndoAlt,
    faRedoAlt
);

export default {
    props: ['editor', 'mode'],

    components: {
        FontAwesomeIcon,
    },
}

</script>
