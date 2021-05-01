<template>
    <span class="z-10">
        <div
            class="
                fixed top-0 left-0
                w-full h-full
                z-50 flex items-center justify-center
            "
            v-show="linkMenuIsActive"
        >
            <div class="card z-20 bg-white px-8 py-8 w-full w-action max-w-full">
                <div class="flex flex-col items-center">
                    <label class="text-sm">URL</label>
                    <input
                        class="
                            form-input
                            form-input-bordered
                            px-2 py-1 w-full
                            text-sm text-90
                            leading-none
                        "
                        type="text"
                        v-model="url"
                        placeholder="https://"
                    />
                    <div class="mt-1 text-xs text-80">
                        External links should start with http:// or https://
                    </div>

                    <div class="flex items-center mt-4">
                        <input 
                            :id="'openInNewWindow_'+field.attribute"
                            type="checkbox"
                            v-model="openInNewWindow"
                        />
                        <label
                            class="text-sm ml-2"
                            :for="'openInNewWindow_'+field.attribute"
                        >
                            Open in new window
                        </label>
                    </div>
                    
                    <div class="flex items-center mt-6">
                        <button
                            type="button"
                            class="mx-1 btn btn-default h-8 text-sm px-3 leading-none"
                            @click="hideLinkMenu"
                        >
                            Cancel
                        </button>

                        <button
                            type="button"
                            class="mx-1 btn btn-default btn-primary h-8 text-sm px-3 leading-none"
                            @click="setLink($event)"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </div>

            <div 
                class="
                    z-10 absolute top-0 left-0 w-full h-full
                    bg-info-dark opacity-75
                "
                @click="hideLinkMenu"
            >
            </div>
        </div>

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
            
            @click="showLinkMenu"
        >
            <font-awesome-icon :icon="['fas', 'link']">
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
            :class="{}"
            @click="unsetLink()"
        >
            <font-awesome-icon :icon="['fas', 'unlink']">
            </font-awesome-icon>
        </button>
    </span>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'

import { faLink, faUnlink, faTimesCircle } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faLink, faUnlink, faTimesCircle)

export default {
    props: [
        'button', 
        'editor',
        'field',
    ],

    data: function () {
        return {
            linkMenuIsActive: false,
            url: '',
            openInNewWindow: false,
        }
    },

    components: {
        FontAwesomeIcon,
    },

    methods: {
        showLinkMenu() {
            console.log(this.editor);
           // this.linkMenuIsActive = true;
        },

        hideLinkMenu() {
            this.linkMenuIsActive = false;
        },

        setLink(e) {
            e.preventDefault();
            let attributes = {
                href: this.url
            };

            if (this.openInNewWindow) {
                attributes.target = '_blank';
            }

            this.editor.chain().focus().setLink(attributes).run();
            this.hideLinkMenu();
        },

        unsetLink() {
            this.editor.chain().focus().unsetLink().run();
        }
    }
}
</script>
