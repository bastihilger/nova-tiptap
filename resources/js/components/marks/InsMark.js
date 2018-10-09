import { Mark } from 'tiptap'
import { toggleMark, markInputRule } from 'tiptap-commands'

export default class InsMark extends Mark {

    get name() {
        return 'ins'
    }

    get schema() {
        return {
            parseDOM: [
                {
                    tag: 'ins',
                },

            ],
            toDOM: () => ['ins', 0],
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
