<template>
  <node-view-wrapper>
    <div
        class="
            relative w-full my-8
        "
        contenteditable="false"
    >
        <div 
            class="flex justify-center"
        >
            <div
                v-text="label"
                class="
                    bg-60 rounded-t text-white uppercase font-bold text-xs
                    px-2 pt-1
                "
                draggable="true"
                data-drag-handle
            >

            </div>
        </div>

        <div
            class="
                w-full flex justify-between items-center
                bg-60 px-3 py-2 rounded-lg
            "
        >
            <div
                class="cursor-move pr-4 text-white text-lg"
                draggable="true"
                data-drag-handle
            >
                <font-awesome-icon :icon="['fas', 'grip-horizontal']">
                </font-awesome-icon>
            </div>

            <div class="w-full">
                <slot />
            </div>

            <div
                class="pl-4 text-white text-lg cursor-pointer"
                @click="deleteBlock"
            >
                <font-awesome-icon :icon="['fas', 'trash-alt']">
                </font-awesome-icon>
            </div>

        </div>

        <div 
            class="flex justify-center hidden"
        >
            <div
                v-text="nodeKey"
                class="
                   text-xs
                   pt-1
                "
                
            >

            </div>
        </div>
    </div>
  </node-view-wrapper>
</template>

<script>
import { NodeViewWrapper } from '@tiptap/vue-2'

import { library } from '@fortawesome/fontawesome-svg-core';

import { 
    faGripHorizontal,
    faTrashAlt,
} from '@fortawesome/free-solid-svg-icons';

library.add(
    faGripHorizontal,
    faTrashAlt,
);

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

export default {
    props: { 
        label: String,
        nodeKey: String|Number,
    },

    components: {
        NodeViewWrapper,
        FontAwesomeIcon
    },

    methods: {
        deleteBlock() {
            this.$el.remove();
        },
    }
}
</script>
