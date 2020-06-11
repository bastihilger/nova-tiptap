<template>
    <button
        type="button"
        class="
            btn
            btn-default
            p-2
            leading-none
            text-xs
            min-w-8
            h-8
            tiptap-button
        "
        :class="[
            (buttonKey == 'bold' && isActive.bold() ? 'btn-primary' : ''),
            (buttonKey == 'italic' && isActive.italic() ? 'btn-primary' : ''),
            (buttonKey == 'code' && isActive.code() ? 'btn-primary' : ''),
            (buttonKey == 'bullet_list' && isActive.bullet_list() ? 'btn-primary' : ''),
            (buttonKey == 'ordered_list' && isActive.ordered_list() ? 'btn-primary' : ''),
            (buttonKey == 'code_block' && isActive.code_block() ? 'btn-primary' : ''),
            (buttonKey == 'blockquote' && isActive.blockquote() ? 'btn-primary' : ''),
            'is-' + buttonKey

        ]"
        @click="commands[buttonKey]"
    >
        <font-awesome-icon v-if="buttonKey == 'bullet_list'" :icon="['fas', 'list-ul']">
        </font-awesome-icon>

        <font-awesome-icon v-if="buttonKey == 'ordered_list'" :icon="['fas', 'list-ol']">
        </font-awesome-icon>

        <font-awesome-icon v-if="buttonKey == 'blockquote'" :icon="['fas', 'quote-right']">
        </font-awesome-icon>

        <font-awesome-icon v-if="buttonKey == 'edit_html'" :icon="['fas', 'file-code']">
        </font-awesome-icon>
    </button>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'

import {faCode, faListUl, faListOl, faQuoteRight, faFileCode} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faCode, faListUl, faListOl, faQuoteRight, faFileCode)


export default {
    props: ['buttonKey', 'isActive', 'commands'],

    components: {
        FontAwesomeIcon,
    },
}
</script>



