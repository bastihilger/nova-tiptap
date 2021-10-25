import { Node, mergeAttributes } from '@tiptap/core'
import { VueNodeViewRenderer } from '@tiptap/vue-2'
import VideoContentBlock from './VideoContentBlock.vue'

export default Node.create({
    name: 'videoContentBlock',

    group: 'block',

    atom: true,

    draggable: true,

    addAttributes() {
        return {
            embedCode: {
                default: '',
            },
            caption: {
                default: '',
            },
            credits: {
                default: '',
            },
            ratio: {
                default: '16:9',
            },
            key: {
                default: '',
            },
        }
    },

    parseHTML() {
        return [
            {
                tag: 'video-content-block',
            },
        ]
    },

    renderHTML({ HTMLAttributes }) {
        return ['video-content-block', mergeAttributes(HTMLAttributes)]
    },

    addNodeView() {
        return VueNodeViewRenderer(VideoContentBlock)
    },
})
