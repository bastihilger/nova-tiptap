<template>
    <span>
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
                (isActive.table() ? 'btn-primary' : '')
            ]"
            @click="commands.createTable({rowsCount: 2, colsCount: 2, withHeaderRow: false })"
        >
            <font-awesome-icon :icon="['fas', 'table']">
            </font-awesome-icon>
        </button>
    </span>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'

import { faTable } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faTable)

export default {
    props: ['isActive', 'commands'],

    components: {
        FontAwesomeIcon,
    },
}
</script>



