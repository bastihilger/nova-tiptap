<template>
    <span>
        <form
            class="
                tiptap-button-form
                btn
                btn-default
                p-2
            "
            v-show="linkMenuIsActive"
            @submit.prevent="setLinkUrl(commands.link, linkUrl)"
        >
            <input
                class="
                    form-input
                    form-input-bordered
                    p-1
                    text-xs
                    leading-none
                "
                type="text"
                v-model="linkUrl"
                placeholder="https://"
                ref="linkInput"
                @keydown.esc="hideLinkMenu"
            />

            <button
                class="btn is-close"
                @click="setLinkUrl(commands.link, null)"
                type="button"
            >
                <font-awesome-icon :icon="['far', 'times-circle']">
                </font-awesome-icon>
            </button>
        </form>

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
                (isActive.link() ? 'btn-primary' : '')
            ]"
            @click="showLinkMenu(getMarkAttrs('link'))"
        >
            <font-awesome-icon :icon="['far', 'link']">
            </font-awesome-icon>
        </button>

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
                (isActive.link() ? 'btn-primary' : '')
            ]"
            @click="setLinkUrl(commands.link, null)"
        >
            <font-awesome-icon :icon="['far', 'unlink']">
            </font-awesome-icon>
        </button>
    </span>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'

import { faLink, faUnlink, faTimesCircle } from '@fortawesome/pro-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faLink, faUnlink, faTimesCircle)

export default {
    props: [
        'getMarkAttrs',
        'linkMenuIsActive',
        'isActive',
        'commands',
        'linkUrl',
        'hideLinkMenu',
        'showLinkMenu',
        'setLinkUrl',
    ],

    components: {
        FontAwesomeIcon,
    },
}
</script>



