<template>
  <node-view-wrapper>
    <div 
        class="
            w-full flex justify-between items-center
            bg-30 px-3 py-2 rounded-lg shadow-sm my-4
        "
        contenteditable="false"
    >
        <div
            class="cursor-move pr-4 text-60 text-lg"
            contenteditable="false"
            draggable="true"
            data-drag-handle
        >
            <font-awesome-icon :icon="['fas', 'grip-horizontal']">
            </font-awesome-icon>
        </div>

        <div class="w-full">
            <node-view-content class="text-80" contenteditable="false" />
        </div>

        <div
            class="pl-4 text-60 text-lg cursor-pointer"
            contenteditable="false"
            @click="deleteBlock"
        >
            <font-awesome-icon :icon="['fas', 'trash-alt']">
            </font-awesome-icon>
        </div>
    </div>
  </node-view-wrapper>
</template>

<script>
import { NodeViewWrapper, NodeViewContent, nodeViewProps } from '@tiptap/vue-2'

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
  props: nodeViewProps,

  components: {
    NodeViewWrapper,
    NodeViewContent,
    FontAwesomeIcon
  },

  methods: {
      deleteBlock() {
          this.$el.remove();
      }
  }
}
</script>
