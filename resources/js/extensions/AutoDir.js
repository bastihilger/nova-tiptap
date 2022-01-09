import { Extension } from '@tiptap/core'

export default Extension.create({
  name: 'AutoDir',
  addGlobalAttributes() {
    return [   
      {
        types: [
          'heading',
          'paragraph',
          'bulletList',
          'orderedList',
          'blockquote',
        ],
        attributes: {
          autoDir: {
            renderHTML: attributes => ({
              dir: 'rtl',
            }),
            parseHTML: element => element.dir || 'rtl',
          },
        },
      },
    ]
  },
})
