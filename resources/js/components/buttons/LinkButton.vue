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
            <div class="rounded-lg shadow-lg overflow-hidden z-20 w-full w-action-fields max-w-full">
                <div class="px-8 py-8 bg-white">
                    <template v-if="withFileUpload">
                        <span 
                            class="cursor-pointer font-bold text-sm border-b-2 "
                            :class="{
                                'text-primary border-primary': linkMode == 'url',
                                'text-80 border-transparent': linkMode != 'url'
                            }"
                            @click="linkMode = 'url'"
                            v-text="__('url')"
                        >
                        </span>

                        <span 
                            class="ml-2 cursor-pointer font-bold text-sm border-b-2 "
                            :class="{
                                'text-primary border-primary': linkMode == 'file',
                                'text-80 border-transparent': linkMode != 'file'
                            }"
                            @click="linkMode = 'file'"
                            v-text="__('file upload')"
                        >
                        </span>
                    </template>
                </div>

                <div class="px-8 pb-8 bg-white">
                    <div v-show="linkMode == 'url'">
                        <div class="flex flex-col">
                            <label 
                                class="text-sm mb-1 ml-1"
                                v-text="__('url')"
                            >
                            </label>

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

                            <div 
                                class="ml-1 mt-1 text-xs text-80"
                                v-text="__('external links should start with http:// or https://')"
                            >
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
                                    v-text="__('open in new window')"
                                >
                                </label>
                            </div>
                        </div>
                    </div>

                    <div 
                        v-if="withFileUpload" 
                        v-show="linkMode == 'file'"
                    >
                        <div 
                            class="flex items-center transition-opacity duration-150"
                            :class="{
                                'pointer-events-none opacity-50': uploading
                            }" 
                        >   
                            <label class="relative btn btn-default btn-primary">
                                <input 
                                    ref="fileInput"
                                    type="file" 
                                    @change="changeFile($event.target.files)"
                                    class="opacity-0 w-full h-full absolute top-0 left-0"
                                />
                                <span v-text="__('select file')"></span>
                            </label>

                            <div class="ml-8 h-16 flex items-center">
                                <span 
                                    v-if="!file"
                                    v-text="__('no file selected')"
                                >
                                </span>

                                <span 
                                    v-if="file"
                                    v-text="filename"
                                >
                                </span>
                            </div>

                            <div 
                                v-if="file"
                                @click="removeFile()"
                                class="
                                    cursor-pointer ml-8 text-xl text-primary
                                "
                            >
                                <font-awesome-icon :icon="['fas', 'trash-alt']">
                                </font-awesome-icon>
                            </div>
                        </div>

                        <div 
                            class="w-full h-2 mt-4"
                            :class="{
                                'bg-20': uploading
                            }"
                        >
                            <div 
                                class="
                                    bg-primary h-full
                                "
                                :style="{
                                    'width': uploadProgress+'%'
                                }"
                            >

                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <label 
                            class="block text-sm mb-1 ml-1"
                            v-text="__('custom css classes')"
                        >
                        </label>

                        <input
                            class="
                                form-input
                                form-input-bordered
                                px-2 py-1 w-full
                                text-sm text-90
                                leading-none
                            "
                            type="text"
                            v-model="extraClasses"
                        />

                        <label 
                            class="block text-sm mt-4 mb-1 ml-1"
                            v-text="__('title')"
                        >
                        </label>

                        <input
                            class="
                                form-input
                                form-input-bordered
                                px-2 py-1 w-full
                                text-sm text-90
                                leading-none
                            "
                            type="text"
                            v-model="title"
                        />

                        <div class="
                            grid grid-cols-3 gap-4
                        ">
                            <div class="flex items-center mt-5">
                                <input 
                                    :id="'nofollow_'+field.attribute"
                                    type="checkbox"
                                    v-model="nofollow"
                                />
                                <label
                                    class="text-sm ml-2"
                                    :for="'nofollow_'+field.attribute"
                                    v-text="'nofollow'"
                                >
                                </label>
                            </div>

                            <div class="flex items-center mt-5">
                                <input 
                                    :id="'noopener_'+field.attribute"
                                    type="checkbox"
                                    v-model="noopener"
                                />
                                <label
                                    class="text-sm ml-2"
                                    :for="'noopener_'+field.attribute"
                                    v-text="'noopener'"
                                >
                                </label>
                            </div>

                            <div class="flex items-center mt-5">
                                <input 
                                    :id="'noreferrer_'+field.attribute"
                                    type="checkbox"
                                    v-model="noreferrer"
                                />
                                <label
                                    class="text-sm ml-2"
                                    :for="'noreferrer_'+field.attribute"
                                    v-text="'noreferrer'"
                                >
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-30 px-6 py-3">   
                    <div class="flex items-center justify-end">
                        <button
                            type="button"
                            class="btn h-9 px-3 font-normal text-80"
                            @click="hideLinkMenu"
                            v-text="__('cancel')"
                        >
                        </button>

                        <button
                            type="button"
                            class="ml-3 btn btn-default btn-primary"
                            :disabled="(linkMode == 'url' && !url) || (linkMode == 'file' && !file)"
                            @click="linkMode == 'url' ? setLinkFromUrl($event) : uploadAndAddFile($event)"
                            v-text="linkMode == 'url' ? __('set link') : __('upload and link file')"
                        >
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
            <base-button
                :isActive="linkIsActive"
                :isDisabled="!linkCanBeUsed"
                :clickMethod="showLinkMenu"
                :title="!linkIsActive ? __('set link') : __('edit link')"
                :icon="['fas', 'link']"
            >
            </base-button>

            <base-button
                :isActive="linkIsActive"
                :isDisabled="!linkCanBeUsed"
                :clickMethod="unsetLink"
                :title="__('unset link')"
                :icon="['fas', 'unlink']"
            >
            </base-button>
        </span>
    </span>
</template>

<script>
import buttonHovers from '../../mixins/buttonHovers';

import { library } from '@fortawesome/fontawesome-svg-core';

import { faTimesCircle } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import BaseButton from './BaseButton.vue';

library.add(faTimesCircle);

export default {
    mixins: [buttonHovers],

    props: [
        'button', 
        'editor',
        'field',
        'mode',
        'fileDisk',
        'filePath',
    ],

    data: function () {
        return {
            linkMenuIsActive: false,
            url: '',
            openInNewWindow: false,
            file: null,
            filename: null,
            uploadProgress: 0,
            uploading: false,
            extraClasses: '',
            linkMode: 'url',
            title: '',
            nofollow: false,
            noopener: false,
            noreferrer: false,
        }
    },

    components: {
        FontAwesomeIcon,
        BaseButton,
    },

    computed: {
        linkIsActive() {
           return this.editor ? this.editor.isActive('link') : false;
        },

        linkCanBeUsed() {
           return this.editor ? (this.mode == 'editor' && !this.editor.isActive('image')) : true;
        },

        withFileUpload() {
            return !this.field.linkSettings
                    ||
                    (
                        typeof(this.field.linkSettings.withFileUpload) != 'boolean'
                        || this.field.linkSettings.withFileUpload
                    );
        },
    },

    methods: {
        showLinkMenu() {
            if (this.linkIsActive) {
                let attributes = this.editor.getAttributes('link');
                this.url = attributes.href;
                this.openInNewWindow = attributes.target == '_blank' ? true : false;
                this.linkMode = attributes['tt-mode'] ? attributes['tt-mode'] : 'url';
                this.extraClasses = attributes.class ? attributes.class : '';
                this.title = attributes.title ? attributes.title : '';
                this.nofollow = attributes.rel && attributes.rel.indexOf('nofollow') > -1 ? true : false;
                this.noopener = attributes.rel && attributes.rel.indexOf('noopener') > -1 ? true : false;
                this.noreferrer = attributes.rel && attributes.rel.indexOf('noreferrer') > -1 ? true : false;
            } else {
                this.url = '';
                this.openInNewWindow = false;
                this.nofollow = false;
                this.noopener = false;
                this.noreferrer = false;
                this.linkMode = 'url';
                this.extraClasses = '';
                this.title = '';
            }
            
            this.linkMenuIsActive = true;
        },

        hideLinkMenu() {
            this.linkMenuIsActive = false;
        },

        removeFile() {
            this.file = null;
            this.filename = null;
            this.$refs.fileInput.value=null;
         },

         resetUploading() {
            this.uploading = false;
            this.uploadProgress = 0;
         },

         changeFile(files) {
            if (files.length) {
                this.file = files[0];
                this.filename = this.file.name;
            }
         },

        uploadAndAddFile(e) {
            e.preventDefault();

            this.uploading = true;
            
            let data = new FormData();
            data.append('file', this.file);   
            data.append('disk', this.fileDisk);   
            data.append('path', this.filePath);   

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: progressEvent => this.uploadProgress = (progressEvent.loaded / progressEvent.total) * 100
            };

            axios.post('/nova-tiptap/api/file', data, config)
                .then(function (response) {
                    this.resetUploading();
                    this.removeFile();
                    
                    let attributes = {
                        href: response.data.url,
                        'tt-mode': 'file',
                        download: 'true',
                    };

                    this.setLink(attributes);
                    
                    this.hideLinkMenu();
                }.bind(this))
                .catch(function (error) {
                    this.resetUploading();
                    this.removeFile();
                }.bind(this));
        },

        setLinkFromUrl(e) {
            e.preventDefault();

            let attributes = {
                href: this.url,
                'tt-mode': 'url',
            };

            if (this.openInNewWindow) {
                attributes.target = '_blank';
            } else {
                attributes.target = '_self';
            }

            this.setLink(attributes);
            
            this.hideLinkMenu();
        },

        setLink(attributes) {
            if (this.extraClasses) {
                attributes.class = this.extraClasses;
            }
            if (this.title) {
                attributes.title = this.title;
            }
            if (this.nofollow || this.noopener || this.noreferrer) {
                attributes.rel = '';
                if (this.nofollow) {
                    attributes.rel += 'nofollow ';
                }
                if (this.noopener) {
                    attributes.rel += 'noopener ';
                }
                if (this.noreferrer) {
                    attributes.rel += 'noreferrer ';
                }
                attributes.rel = _.trim(attributes.rel);
            }

            if (this.editor.isActive('image')) {
                let attributes = this.editor.getAttributes('image');
                
            } else {
                this.editor.chain().extendMarkRange('link').unsetLink().run();
                this.editor.chain().focus().setLink(attributes).run();
            }
            
        },

        unsetLink() {
            this.editor.chain().focus().unsetLink().run();
        }
    }
}
</script>
