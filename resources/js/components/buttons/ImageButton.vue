<template>
    <span class="z-10">
        <Modal 
            :isActive="imageMenuIsActive"
            :hideMethod="hideImageMenu"
        >
            <div class="px-8 py-8 bg-white">
                <div 
                    v-if="!imageIsActive && withFileUpload"
                >
                    <span 
                        class="uppercase cursor-pointer font-bold text-sm border-b"
                        :class="{
                            'text-primary-500 border-primary-500': imageMode == 'file',
                            'text-gray-500 border-transparent': imageMode != 'file'
                        }"
                        @click="imageMode = 'file'"
                        v-text="ttt('file upload')"
                    >
                    </span>

                    <span 
                        class="ml-4 uppercase cursor-pointer font-bold text-sm border-b"
                        :class="{
                            'text-primary-500 border-primary-500': imageMode == 'url',
                            'text-gray-500 border-transparent': imageMode != 'url'
                        }"
                        @click="imageMode = 'url'"
                        v-text="ttt('external url')"
                    >
                    </span>
                </div>

                <div 
                    v-if="!imageIsActive"
                    style="padding-top: 32px;"
                >
                    <div v-if="withFileUpload" v-show="imageMode == 'file'">
                        <div 
                            class="flex items-center"
                            :class="{
                                'pointer-events-none opacity-50': uploading
                            }" 
                        >   
                            <label 
                                class="
                                    relative bg-primary-500 text-white rounded
                                    font-bold shadow py-1 px-4 cursor-pointer
                                "
                            >
                                <input 
                                    ref="fileInput"
                                    type="file" 
                                    @change="changeFile($event.target.files)"
                                    accept="image/*" 
                                    class="w-full h-full absolute top-0 left-0"
                                    style="opacity: 0"
                                />
                                <span v-text="ttt('select file')"></span>
                            </label>

                            <div 
                                class="h-16 flex items-center"
                                style="margin-left: 16px;"
                            >
                                <span 
                                    v-if="!preview"
                                    v-text="ttt('no file selected')"
                                > 
                                </span>
                                <img 
                                    v-if="preview" 
                                    :src="preview" 
                                    class="w-auto" 
                                    style="height: 64px"
                                />
                            </div>

                            <div 
                                v-if="file"
                                @click="removeFile()"
                                class="
                                    cursor-pointer text-xl text-primary
                                "
                                style="margin-left: 16px;"
                            >
                                <font-awesome-icon :icon="['fas', 'trash-alt']">
                                </font-awesome-icon>
                            </div>
                        </div>

                        <div 
                            class="w-full h-2 mt-4"
                            :class="{
                                'bg-gray-200': uploading
                            }"
                        >
                            <div 
                                class="
                                    bg-primary-400 h-full
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
                            <label class="text-sm mb-1 ml-1" v-text="ttt('url')"></label>
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

                <div style="padding-top: 32px">
                    <div class="flex flex-col">
                        <label class="text-sm mb-1 ml-1" v-text="ttt('custom css classes')"></label>
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
                            <label class="text-sm mb-1 ml-1" v-text="ttt('title')"></label>
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

                        <div class="flex flex-col mt-4">
                            <label class="text-sm mb-1 ml-1" v-text="ttt('alt text')"></label>
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

            <div class="bg-gray-200 px-8 py-3">   
                <div class="flex items-center justify-end">
                    <button
                        type="button"
                        class="
                            font-bold py-1 cursor-pointer
                            mr-4
                        "
                        @click="hideImageMenu"
                        v-text="ttt('cancel')"
                    >
                    </button>

                    <button
                        type="button"
                        class="
                            relative bg-primary-500 text-white rounded
                            font-bold shadow py-1 px-4 cursor-pointer
                        "
                        :style="((imageMode == 'url' && !url) || (imageMode == 'file' && !file)) ? 'opacity: 0.5' : ''"
                        
                        :disabled="!imageIsActive && ((imageMode == 'url' && !url) || (imageMode == 'file' && !file))"
                        @click="imageIsActive ? updateImage($event) : (imageMode == 'url' ? addImageFromUrl($event) : uploadAndAddImage($event))"
                        v-text="imageIsActive ? ttt('update image') : (imageMode == 'url' ? ttt('add image') : ttt('upload and add image'))"
                    >
                    </button>
                </div>
            </div>
        </Modal>

        <span class="whitespace-nowrap">
            <base-button
                :isActive="imageIsActive"
                :isDisabled="mode != 'editor'"
                :clickMethod="showImageMenu"
                :icon="['fas', 'image']"
                :title="!imageIsActive ? ttt('add image') : ttt('edit image')"
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
import Modal from '../Modal.vue';

import translations from '../../mixins/translations';

library.add(faTimesCircle, faTrashAlt);

export default {
    mixins: [translations],

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
        Modal,
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
