import { Node, mergeAttributes } from '@tiptap/core'
import { VueNodeViewRenderer } from '@tiptap/vue-2'
import PlaceholderBlock from '../components/PlaceholderBlock.vue'

export default Node.create({
    name: 'placeholderBlock',

    group: 'block',

    content: 'block+',

    draggable: true,

    parseHTML() {
        return [
            {
                tag: 'placeholder-block',
            },
        ]
    },

    renderHTML({ HTMLAttributes }) {
        return ['placeholder-block', mergeAttributes(HTMLAttributes), 0]
    },

    addNodeView() {
        return VueNodeViewRenderer(PlaceholderBlock)
    },
})
