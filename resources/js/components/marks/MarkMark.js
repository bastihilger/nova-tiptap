import { Mark } from 'tiptap'
import { toggleMark, markInputRule } from 'tiptap-commands'

export default class MarkMark extends Mark {

    get name() {
        return 'mark'
    }

    get schema() {
        return {
            parseDOM: [
                {
                    tag: 'mark',
                },

            ],
            toDOM: () => ['mark', 0],
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
