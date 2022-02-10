import { Node, mergeAttributes } from '@tiptap/core'
import { VueNodeViewRenderer } from '@tiptap/vue-2'
import GalleryContentBlock from './GalleryContentBlock.vue'

export default Node.create({
    name: 'galleryContentBlock',

    group: 'block',

    atom: true,

    draggable: true,

    addAttributes() {
        return {
            slides: {
                default: '',
            },
            slideCount: {
                default: 0,
            },
            maxColumns: {
                default: 3,
            },
            mode: {
                default: 'slideshow',
            },
            formatMode: {
                default: 'flexible',
            },
            format: {
                default: '1:1',
            },
            key: {
                default: '',
            },
            imageDisk: {
                default: '',
            },
            imagePath: {
                default: '',
            }
        }
    },

    parseHTML() {
        return [
            {
                tag: 'gallery-content-block',
            },
        ]
    },

    renderHTML({ HTMLAttributes }) {
        return ['gallery-content-block', mergeAttributes(HTMLAttributes)]
    },

    addNodeView() {
        return VueNodeViewRenderer(GalleryContentBlock)
    },
})
