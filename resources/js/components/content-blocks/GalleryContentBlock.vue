<template>
    <ContentBlockWrapper label="Gallery" :nodeKey="node.attrs.key">
        <div 
            @click="showModal" 
            class="cursor-pointer grid grid-cols-2"
        >
            <div 
                class="font-bold"
                v-text="title"  
            />

            <div 
                class=""
                v-text="'Mode: '+node.attrs.mode"  
            />
        </div>

        <div
            class="
                fixed top-0 left-0
                w-full h-full overflow-scroll py-8
                z-50 flex items-center justify-center
            "
            v-show="modalIsActive"
        >
            <div class="m-auto rounded-lg shadow-lg overflow-hidden z-20 w-action-fields max-w-full">
                <div class="px-8 py-8 bg-white">
                    <div class="flex flex-col">
                        <div>
                            <label class="block text-sm mb-2 capitalize" v-text="__('slides')"></label>
                            <div>
                                <div
                                    v-for="(slide, slideIndex) in slides"
                                    :key="slideIndex"
                                    class="my-6 px-2 pt-2 pb-4 bg-40 rounded-lg"
                                >   
                                    <div class="mb-2 flex items-center justify-between text-primary">
                                        <div class="flex items-center">
                                            <div 
                                                v-text="'Slide '+(slideIndex + 1)"
                                            />

                                            <div
                                                class="ml-4 cursor-pointer"
                                                @click="removeSlide(slideIndex)"
                                            >
                                                <font-awesome-icon :icon="['fas', 'trash-alt']">
                                                </font-awesome-icon>
                                                
                                            </div>
                                        </div>

                                        <div>
                                            <div
                                                :class="{
                                                    'pointer-events-none opacity-25': slideIndex == 0,
                                                    'cursor-pointer': slideIndex > 0,
                                                }"
                                                @click="moveUp(slideIndex)"
                                            >
                                                <font-awesome-icon :icon="['fas', 'angle-up']">
                                                </font-awesome-icon>
                                            </div>

                                            <div
                                                :class="{
                                                    'pointer-events-none opacity-25': slideIndex >= slideCount - 1,
                                                    'cursor-pointer': slideIndex < slideCount - 1,
                                                }"
                                                @click="moveDown(slideIndex)"
                                            >
                                                <font-awesome-icon :icon="['fas', 'angle-down']">
                                                </font-awesome-icon>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div 
                                            class="
                                                flex items-center
                                                transition-opacity duration-150
                                            "
                                            :class="{
                                                'pointer-events-none opacity-50': slide.uploading
                                            }" 
                                        >   
                                            <label 
                                                class="relative btn btn-default btn-primary"
                                                v-show="!slide.src"
                                            >
                                                <input 
                                                    :key="slide.fileInputKey"
                                                    type="file" 
                                                    @change="changeFile(slideIndex, $event.target.files)"
                                                    accept="image/*" 
                                                    class="opacity-0 w-full h-full absolute top-0 left-0"
                                                />
                                                <span v-text="__('select file')"></span>
                                            </label>
                                            
                                            
                                            <img v-if="slide.src" :src="slide.src" class="h-16 w-auto" />

                                            <div 
                                                class="ml-8 h-16 flex items-center"
                                                 v-if="!slide.src"
                                            >
                                                <span 
                                                    v-if="!slide.preview"
                                                    v-text="__('no file selected')"
                                                > 
                                                </span>
                                                <img v-if="slide.preview" :src="slide.preview" class="h-16 w-auto" />
                                            </div>

                                            <div 
                                                v-if="slide.src || slide.file"
                                                @click="removeFile(slideIndex)"
                                                class="
                                                    cursor-pointer ml-8 text-xl text-primary
                                                "
                                            >
                                                <font-awesome-icon :icon="['fas', 'times-circle']">
                                                </font-awesome-icon>
                                            </div>

                                            <div
                                                v-if="slide.file"
                                            >
                                                <button
                                                    type="button"
                                                    class="ml-6 btn btn-default btn-primary"
                                                    :disabled="!slide.preview"
                                                    @click="uploadImage(slideIndex, $event)"
                                                    v-text="__('upload and add image')"
                                                >
                                                </button>
                                            </div>
                                        </div>

                                        <div 
                                            class="w-full h-2 mt-2"
                                            :class="{
                                                'bg-20': slide.uploading
                                            }"
                                        >
                                            <div 
                                                class="
                                                    bg-primary h-full
                                                "
                                                :style="{
                                                    'width': slide.uploadProgress+'%'
                                                }"
                                            >

                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2  gap-x-6 gap-y-4">
                                        <div>
                                            <label class="block text-sm mb-1 ml-1 capitalize" v-text="__('caption')" />

                                            <input
                                                type="text"
                                                class="
                                                    form-input
                                                    form-input-bordered
                                                    px-2 py-1 w-full
                                                    text-sm text-90
                                                    leading-none
                                                "
                                                v-model="slides[slideIndex].caption"
                                            />
                                        </div>

                                        <div>
                                            <label class="block text-sm mb-1 ml-1 capitalize" v-text="__('credits')" />

                                            <input
                                                type="text"
                                                class="
                                                    form-input
                                                    form-input-bordered
                                                    px-2 py-1 w-full
                                                    text-sm text-90
                                                    leading-none
                                                "
                                                v-model="slides[slideIndex].credits"
                                            />
                                        </div>

                                        <div>
                                            <label class="block text-sm mb-1 ml-1 capitalize" v-text="__('link')" />

                                            <input
                                                type="text"
                                                class="
                                                    form-input
                                                    form-input-bordered
                                                    px-2 py-1 w-full
                                                    text-sm text-90
                                                    leading-none
                                                "
                                                v-model="slides[slideIndex].link"
                                            />
                                        </div>

                                        <div>
                                            <label class="block text-sm mb-1 ml-1 capitalize" v-text="__('link target')" />
                                            <select
                                                class="
                                                    form-input
                                                    form-input-bordered
                                                    px-2 py-1 w-full
                                                    text-sm text-90
                                                    leading-none
                                                "
                                                v-model="slides[slideIndex].linkTarget"
                                            >
                                                <option 
                                                    value=""
                                                    v-text="__('same tab/window')"
                                                />
                                                <option 
                                                    value="_blank"
                                                    v-text="__('new tab/window')"
                                                />
                                            </select>
                                        </div>

                                        <div class="col-span-2">
                                            <label class="block text-sm mb-1 ml-1 capitalize" v-text="__('embed code')" />
                                            <textarea
                                                class="
                                                    form-input
                                                    form-input-bordered
                                                    px-2 py-1 w-full
                                                    text-sm text-90
                                                    leading-none h-16
                                                "
                                                v-model="slides[slideIndex].embedCode"
                                            />      
                                        </div>

                                        <div class="col-span-2">
                                            <label class="block text-sm mb-1 ml-1 capitalize" v-text="__('text')" />
                                            
                                            <trix-editor
                                                ref="textEditor"
                                                @keydown.stop
                                                @trix-change="updateSlideText(slideIndex)"
                                                @trix-initialize="initSlideText(slideIndex)"
                                                :value="slides[slideIndex].text"
                                                class="bg-white"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button
                                        type="button"
                                        class="btn btn-default btn-primary"
                                        @click="addSlide()"
                                        v-text="__('add slide')"
                                    >
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm mb-2 capitalize" v-text="__('mode')"></label>
                                <div
                                    v-for="(modeName, modeOption) in modeOptions" 
                                    :key="modeOption"
                                    class="inline-flex mr-4 items-center"
                                >
                                    <input
                                        type="radio"
                                        class="
                                            radio h-5 w-5
                                        "
                                        :value="modeOption"
                                        v-model="mode"
                                        :id="modeOption"
                                    />
                                    <label 
                                        :for="modeOption"
                                        v-text="modeName"
                                        class="ml-2"
                                    />
                                </div>
                            </div>

                            <div v-show="mode == 'grid'">
                                <label class="block text-sm mb-1 ml-1 capitalize" v-text="__('max columns')"></label>
                                <select
                                    class="
                                        form-input
                                        form-input-bordered
                                        px-2 py-1 w-full
                                        text-sm text-90
                                        leading-none
                                    "
                                    v-model="maxColumns"
                                >
                                    <option 
                                        v-for="num in 12" 
                                        :key="num"
                                        :value="num"
                                        v-text="num"
                                    />
                                </select>
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm mb-2 capitalize" v-text="__('format mode')"></label>
                                <div
                                    v-for="(formatModeName, formatModeOption) in formatModeOptions" 
                                    :key="formatModeOption"
                                    class="inline-flex mr-4 items-center"
                                >
                                    <input
                                        type="radio"
                                        class="
                                            radio h-5 w-5
                                        "
                                        :value="formatModeOption"
                                        v-model="formatMode"
                                        :id="formatModeOption"
                                    />
                                    <label 
                                        :for="formatModeOption"
                                        v-text="formatModeName"
                                        class="ml-2"
                                    />
                                </div>
                            </div>

                            <div v-show="formatMode == 'fixed'">
                                <label class="block text-sm mb-1 ml-1 capitalize" v-text="__('format')"></label>
                                <select
                                    class="
                                        form-input
                                        form-input-bordered
                                        px-2 py-1 w-full
                                        text-sm text-90
                                        leading-none
                                    "
                                    v-model="format"
                                >
                                    <option 
                                        v-for="fixedModeOption in fixedModeOptions" 
                                        :key="fixedModeOption"
                                        :value="fixedModeOption"
                                        v-text="fixedModeOption"
                                    />
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-30 px-6 py-3">   
                    <div class="flex items-center justify-end">
                        <button
                            type="button"
                            class="btn h-9 px-3 font-normal text-80"
                            @click="hideMenu"
                            v-text="__('cancel')"
                        >
                        </button>

                        <button
                            type="button"
                            class="ml-3 btn btn-default btn-primary"
                            @click="update()"
                            v-text="__('update gallery')"
                        >
                        </button>
                    </div>
                </div>
            </div>

            <div 
                class="
                    z-10 fixed top-0 left-0 w-full h-full
                    bg-80 opacity-75
                "
                @click="hideMenu"
            >
            </div>
        </div>
    </ContentBlockWrapper>
</template>

<script>

import { library } from '@fortawesome/fontawesome-svg-core';

import { faTimesCircle, faTrashAlt, faAngleDown, faAngleUp } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faTimesCircle, faTrashAlt, faAngleDown, faAngleUp);

import ContentBlockWrapper from './ContentBlockWrapper';
import { nodeViewProps } from '@tiptap/vue-2';

export default {
    props: nodeViewProps,

    components: {
        ContentBlockWrapper, FontAwesomeIcon
    },

    data() {
        return {
            modalIsActive: false,
            slides: [],
            uploadingIndexes: [],
            mode: '',
            formatMode: 'flexible',
            format: '',
            maxColumns: 1,
            modeOptions: {
                slideshow: 'Slideshow',
                grid: 'Grid',
            },
            formatModeOptions: {
                flexible: 'flexible',
                fixed: 'fixed',
            },
            fixedModeOptions: [
                '16:9',
                '4:3',
                '1:1',
                '9:16',
                '3:4',
                '2:1',
                '8:5',
            ],
            imageDisk: '',
            imagePath: '',
            fileDisk: '',
            filePath: '',
        }
    },

    computed: {
        title() {
            return this.node.attrs.slideCount+' Slide(s)';  
        },
        slideCount() {
            return _.size(this.slides);
        }
    },

    methods: {
        initSlideText(index) {
            this.$refs.textEditor[index].editor.insertHTML(this.slides[index].text)
                //this.$refs.theEditor.editor.insertHTML(this.value)
        },
        updateSlideText(index) {
            this.slides[index].text = this.$refs.textEditor[index].value
        },
        addSlide() {
            let key = String(_.random(0, 999))+String(Date.now());
            let fileInputKey = String(_.random(0, 999))+String(Date.now());
            this.slides.push({
                key: key,
                fileInputKey: fileInputKey,
                caption: '',
                credits: '',
                preview: '',
                file: '',
                src: '',
                link: '',
                linkTarget: '',
                embedCode: '',
                text: '',
                uploading: false,
                uploadProgress: 0,
            });
            
        },

        removeSlide(index) {
            let newSlides = [];

            for(let i = 0; i < this.slideCount; i++) {
                if (i != index) {
                    newSlides.push(this.slides[i]);
                }
            }

            this.slides = newSlides;
        },

        moveDown(index) {
            let newSlides = [];

            for(let i = 0; i < this.slideCount; i++) {
                if (i != index) {
                    newSlides.push(this.slides[i]);
                }
                if (i == index + 1 || i == this.slideCount -1 && index == this.slideCount -1) {
                    newSlides.push(this.slides[index]);
                }
            }

            this.slides = newSlides;
        },

        moveUp(index) {
            let newSlides = [];
            
            for(let i = 0; i < this.slideCount; i++) {
                if (i == index - 1 || i == 0 && index == 0) {
                    newSlides.push(this.slides[index]);
                }

                if (i != index) {
                    newSlides.push(this.slides[i]);
                }
                
            }

            this.slides = newSlides;
        },

        resetUploading(index) {
            this.slides[index].uploading = false;
            this.slides[index].uploadProgress = 0;
         },

         changeFile(index, files) {
            if (files.length) {
                this.slides[index].src = '';
                this.slides[index].file = files[0];
                this.slides[index].preview = URL.createObjectURL(this.slides[index].file);
            }
         },

        removeFile(index) {
            this.slides[index].fileInputKey = String(_.random(0, 999))+String(Date.now());
            this.slides[index].file = null;
            this.slides[index].src = '';
            this.slides[index].preview = null;
            
        },

        uploadImage(index, e) {
            e.preventDefault();
            this.slides[index].uploading = true;
            
            let data = new FormData();
            data.append('file', this.slides[index].file);   
            data.append('disk', parseInt(this.node.attrs.imageDisk) != 0 ? this.node.attrs.imageDisk : '');   
            data.append('path', parseInt(this.node.attrs.imagePath) != 0 ? this.node.attrs.imagePath : '');   

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: progressEvent => this.slides[index].uploadProgress = (progressEvent.loaded / progressEvent.total) * 100
            };

            axios.post('/nova-tiptap/api/image', data, config)
                .then(function (response) {
                    this.resetUploading(index);
                    this.removeFile(index);
                    this.slides[index].src = response.data.url;
                    
                }.bind(this))
                .catch(function (error) {
                    this.resetUploading(index);
                    this.removeFile(index);
                    console.log(error);
                }.bind(this));
        },

        showModal() {
            this.slides = _.size(this.node.attrs.slides) ? JSON.parse(this.node.attrs.slides) : [];
            this.mode = this.node.attrs.mode;
            this.formatMode = this.node.attrs.formatMode ? this.node.attrs.formatMode : 'flexible';
            this.format = this.node.attrs.format ? this.node.attrs.format : 'square';
            this.maxColumns = this.node.attrs.maxColumns ? this.node.attrs.maxColumns : 3;
            this.modalIsActive = true;
        },

        update() {
            this.updateAttributes({
                slides: this.slides ? JSON.stringify(this.slides) : '',
                mode: this.mode,
                maxColumns: this.maxColumns,
                formatMode: this.formatMode,
                format: this.format,
                slideCount: this.slides ? _.size(this.slides) : 0,
            });

            this.hideMenu();
        },

        hideMenu() {
            this.modalIsActive = false;
        },

        deleteBlock() {
            this.$el.remove();
        },

        __(str) {
            return str;
        }
    },

    mounted() {
        this.imageDisk = parseInt(this.node.attrs.imageDisk) != 0 ? this.node.attrs.imageDisk : '';   
        this.imagePath = parseInt(this.node.attrs.imagePath) != 0 ? this.node.attrs.imagePath : '';  
        this.fileDisk = parseInt(this.node.attrs.fileDisk) != 0 ? this.node.attrs.fileDisk : '';   
        this.filePath = parseInt(this.node.attrs.filePath) != 0 ? this.node.attrs.filePath : '';   
    }
}
</script>
