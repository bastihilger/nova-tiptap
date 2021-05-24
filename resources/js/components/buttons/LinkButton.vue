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
            <div class="rounded-lg shadow-lg overflow-hidden z-20 w-full w-action max-w-full">
                <div class="px-8 py-8 bg-white">
                     <div class="flex flex-col">
                        <label class="text-sm mb-1 ml-1">URL</label>
                        <input
                            class="
                                form-input
                                form-input-bordered
                                px-2 py-1 w-full
                                text-sm text-90
                                leading-none
                            "
                            type="text"
                            v-model="href"
                            placeholder="https://"
                        />
                        <div class="ml-1 mt-1 text-xs text-80">
                            External links should start with http:// or https://
                        </div>

                        <div class="flex items-center mt-5">
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
                     </div>
                </div>

                <div class="bg-30 px-6 py-3 ">   
                    <div class="flex items-center justify-end">
                        <button
                            type="button"
                            class="btn h-9 px-3 font-normal text-80"
                            @click="hideLinkMenu"
                        >
                            Cancel
                        </button>

                        <button
                            type="button"
                            class="ml-3 btn btn-default btn-primary"
                            @click="setLink($event)"
                        >
                            Update Link
                        </button>
                    </div>
                </div>
            </div>

            <div 
                class="
                    z-10 absolute top-0 left-0 w-full h-full
                    bg-80 opacity-75
                "
                @click="hideLinkMenu"
            >
            </div>
        </div>

        <span class="whitespace-nowrap">
            <button
                type="button"
                class="
                    btn btn-default
                    p-2 ml-1 my-1 mr-0
                    leading-none text-xs
                    min-w-8 h-8 
                    tiptap-button
                "
                :class="{ 
                    'btn-primary': linkIsActive,
                    'bg-white hover:bg-20': !linkIsActive,
                    'opacity-50 pointer-events-none': mode != 'editor',
                }"
                
                @click="showLinkMenu"
            >
                <font-awesome-icon :icon="['fas', 'link']">
                </font-awesome-icon>
            </button>
            <button
                type="button"
                class="
                    btn btn-default
                    p-2 m-1
                    leading-none text-xs
                    min-w-8 h-8
                    tiptap-button
                "
                :class="{ 
                    'btn-primary': linkIsActive,
                    'bg-white hover:bg-20': !linkIsActive,
                    'opacity-50 pointer-events-none': mode != 'editor',
                }"
                @click="unsetLink()"
            >
                <font-awesome-icon :icon="['fas', 'unlink']">
                </font-awesome-icon>
            </button>
        </span>
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
        'mode',
    ],

    data: function () {
        return {
            linkMenuIsActive: false,
            href: '',
            openInNewWindow: false,
        }
    },

    components: {
        FontAwesomeIcon,
    },

    computed: {
        linkIsActive() {
           return this.editor ? this.editor.isActive('link') : false;
        }
    },

    methods: {
        showLinkMenu() {
            let attributes = this.editor.getMarkAttributes('link');
            this.href = attributes.href ? attributes.href : '';
            this.openInNewWindow = attributes.target == '_blank' ? true : false;
            
            this.linkMenuIsActive = true;
        },

        hideLinkMenu() {
            this.linkMenuIsActive = false;
        },

        setLink(e) {
            e.preventDefault();

            let attributes = {
                href: this.href
            };

            if (this.openInNewWindow) {
                attributes.target = '_blank';
            } else {
                attributes.target = '_self';
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
