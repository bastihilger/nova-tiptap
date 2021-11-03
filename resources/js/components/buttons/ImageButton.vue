<template>
    <span class="z-10">
        <div
            class="
                fixed top-0 left-0
                w-full h-full
                z-50 flex items-center justify-center
            "
            v-show="imageMenuIsActive"
        >
            <div class="rounded-lg shadow-lg overflow-hidden z-20 w-action-fields max-w-full">
                <div class="px-8 py-8 bg-white">
                    <div 
                        v-if="!imageIsActive && withFileUpload"
                    >
                        <span 
                            class="cursor-pointer font-bold text-sm border-b-2 "
                            :class="{
                                'text-primary border-primary': imageMode == 'file',
                                'text-80 border-transparent': imageMode != 'file'
                            }"
                            @click="imageMode = 'file'"
                            v-text="__('file upload')"
                        >
                        </span>

                        <span 
                            class="ml-2 cursor-pointer font-bold text-sm border-b-2 "
                            :class="{
                                'text-primary border-primary': imageMode == 'url',
                                'text-80 border-transparent': imageMode != 'url'
                            }"
                            @click="imageMode = 'url'"
                            v-text="__('external url')"
                        >
                        </span>
                    </div>

                    <div 
                        v-if="!imageIsActive"
                        class="pt-8"
                    >
                        <div v-if="withFileUpload" v-show="imageMode == 'file'">
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
                                        accept="image/*" 
                                        class="opacity-0 w-full h-full absolute top-0 left-0"
                                    />
                                    <span v-text="__('select file')"></span>
                                </label>

                                <div class="ml-8 h-16 flex items-center">
                                    <span 
                                        v-if="!preview"
                                        v-text="__('no file selected')"
                                    > 
                                    </span>
                                    <img v-if="preview" :src="preview" class="h-16 w-auto" />
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
                        
                        <div 
                            class=""
                            v-show="imageMode == 'url'"
                        >
                            <div class="flex flex-col">
                                <label class="text-sm mb-1 ml-1" v-text="__('url')"></label>
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
                            </div>
                        </div>
                    </div>

                    <div class="pt-8">
                        <div class="flex flex-col">
                            <label class="text-sm mb-1 ml-1" v-text="__('custom css classes')"></label>
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
                        </div>

                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <div class="flex flex-col">
                                <label class="text-sm mb-1 ml-1" v-text="__('title')"></label>
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
                            </div>

                            <div class="flex flex-col">
                                <label class="text-sm mb-1 ml-1" v-text="__('alt text')"></label>
                                <input
                                    class="
                                        form-input
                                        form-input-bordered
                                        px-2 py-1 w-full
                                        text-sm text-90
                                        leading-none
                                    "
                                    type="text"
                                    v-model="alt"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-30 px-6 py-3">   
                    <div class="flex items-center justify-end">
                        <button
                            type="button"
                            class="btn h-9 px-3 font-normal text-80"
                            @click="hideImageMenu"
                            v-text="__('cancel')"
                        >
                        </button>

                        <button
                            type="button"
                            class="ml-3 btn btn-default btn-primary"
                            :disabled="!imageIsActive && ((imageMode == 'url' && !url) || (imageMode == 'file' && !file))"
                            @click="imageIsActive ? updateImage($event) : (imageMode == 'url' ? addImageFromUrl($event) : uploadAndAddImage($event))"
                            v-text="imageIsActive ? __('update image') : (imageMode == 'url' ? __('add image') : __('upload and add image'))"
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
                @click="hideImageMenu"
            >
            </div>
        </div>

        <span class="whitespace-nowrap">
            <base-button
                :isActive="imageIsActive"
                :isDisabled="mode != 'editor'"
                :clickMethod="showImageMenu"
                :icon="['fas', 'image']"
                :title="!imageIsActive ? __('add image') : __('edit image')"
            >
                
            </base-button>
            
            
        </span>
    </span>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core';

import { faTimesCircle, faTrashAlt } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import BaseButton from './BaseButton.vue';

library.add(faTimesCircle, faTrashAlt);

export default {
    props: [
        'button', 
        'editor',
        'field',
        'mode',
        'imageDisk',
        'imagePath',
    ],

    data: function () {
        return {
            imageMenuIsActive: false,
            file: null,
            preview: null,
            url: '',
            uploadProgress: 0,
            uploading: false,
            extraClasses: '',
            imageMode: 'url',
            title: '',
            alt: '',
        }
    },

    components: {
        FontAwesomeIcon,
        BaseButton,
    },

    computed: {
        imageIsActive() {
           return this.editor ? this.editor.isActive('image') : false;
        },
        withFileUpload() {
            return !this.field.imageSettings
                    ||
                    (
                        typeof(this.field.imageSettings.withFileUpload) != 'boolean'
                        || this.field.imageSettings.withFileUpload
                    );
        },
        defaultMode() {
            return this.withFileUpload ? 'file' : 'url';
        }
    },

    methods: {
        showImageMenu() {
            if (this.imageIsActive) {
                let attributes = this.editor.getAttributes('image');
                this.url = attributes.src;
                this.imageMode = attributes['tt-mode'] ? attributes['tt-mode'] : this.defaultMode;
                this.extraClasses = attributes.class ? attributes.class : '';
                this.title = attributes.title ? attributes.title : '';
                this.alt = attributes.alt ? attributes.alt : '';
            } else {
                this.url = '';
                this.imageMode = this.defaultMode;
                this.extraClasses = '';
                this.title = '';
                this.alt = '';
            }
            
            this.imageMenuIsActive = true;
        },

        hideImageMenu() {
            this.imageMenuIsActive = false;
        },

        removeFile() {
            this.file = null;
            this.preview = null;
            this.$refs.fileInput.value=null;
         },

         resetUploading() {
            this.uploading = false;
            this.uploadProgress = 0;
         },

         changeFile(files) {
            if (files.length) {
                this.file = files[0];
                this.preview = URL.createObjectURL(this.file);
            }
         },

        addImageFromUrl(e) {
            e.preventDefault();

            let attributes = {
                src: this.url,
                'tt-mode': 'url',
                class: this.extraClasses,
                title: this.title,
                alt: this.alt,
            };

            this.editor.chain().focus().setImage(attributes).run();
            
            this.hideImageMenu();
        },

        uploadAndAddImage(e) {
            e.preventDefault();

            this.uploading = true;
            
            let data = new FormData();
            data.append('file', this.file);   
            data.append('disk', this.imageDisk);   
            data.append('path', this.imagePath);   

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: progressEvent => this.uploadProgress = (progressEvent.loaded / progressEvent.total) * 100
            };

            axios.post('/nova-tiptap/api/image', data, config)
                .then(function (response) {
                    this.resetUploading();
                    this.removeFile();
                    
                    let attributes = {
                        src: response.data.url,
                        'tt-mode': 'file',
                        class: this.extraClasses,
                        title: this.title,
                        alt: this.alt,
                    };

                    this.editor.chain().focus().setImage(attributes).run();
                    
                    this.hideImageMenu();
                }.bind(this))
                .catch(function (error) {
                    this.resetUploading();
                    this.removeFile();
                    console.log(error);
                }.bind(this));

            
        },

        updateImage(e) {
            e.preventDefault();

            let attributes = {
                class: this.extraClasses,
                title: this.title,
                alt: this.alt,
            };

            this.editor.chain().focus().updateAttributes('image', attributes).run();
            
            this.hideImageMenu();
        }
    },
}
</script>
