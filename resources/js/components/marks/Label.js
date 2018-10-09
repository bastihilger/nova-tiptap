import { Mark } from 'tiptap'
import { toggleMark, markInputRule } from 'tiptap-commands'

export default class Label extends Mark {

    get name() {
        return 'label'
    }

    get schema() {
        return {
            parseDOM: [
                {
                    tag: 'label',
                },

            ],
            toDOM: () => ['label', 0],
        }
    }

    keys({ type }) {
        return {
            'Mod-m': toggleMark(type),
        }
    }

    command({ type }) {
        return toggleMark(type)
    }

    inputRules({ type }) {
        return [
            markInputRule(/(?:\*\*|__)([^\*_]+)(?:\*\*|__)$/, type),
        ]
    }

}
