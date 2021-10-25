<template>
    <ContentBlockWrapper label="Video" :nodeKey="node.attrs.key">
        <div 
            @click="showMenu" 
            class="cursor-pointer grid grid-cols-2"
        >
            <div 
                class="font-bold"
                v-text="title"  
            />

            <div 
                class=""
                v-text="'Ratio: '+node.attrs.ratio"  
            />

            <div>
                <span 
                    class="capitalize"
                    v-text="__('caption')+': '"  
                />
                <span 
                    v-text="node.attrs.caption ? node.attrs.caption : ''"  
                />
            </div>

            <div>
                <span 
                    class="capitalize"
                    v-text="__('credits')+': '"  
                />
                <span 
                    v-text="node.attrs.credits ? node.attrs.credits : ''"  
                />
            </div>
        </div>

        <div
            class="
                fixed top-0 left-0
                w-full h-full
                z-50 flex items-center justify-center
            "
            v-show="menuIsActive"
        >
            <div class="rounded-lg shadow-lg overflow-hidden z-20 w-action-fields max-w-full">
                <div class="px-8 py-8 bg-white">
                    <div class="flex flex-col">
                        <div>
                            <label class="text-sm mb-1 ml-1 capitalize" v-text="__('embed code')"></label>
                            <textarea
                                class="
                                    form-input
                                    form-input-bordered
                                    h-32
                                    px-2 py-1 w-full
                                    text-sm text-90
                                    leading-none
                                "
                                v-model="embedCode"
                            />
                        </div>

                        <div class="mt-4">
                            <label class="text-sm mb-1 ml-1 capitalize" v-text="__('caption')"></label>
                            <textarea
                                class="
                                    form-input
                                    form-input-bordered
                                    h-16
                                    px-2 py-1 w-full
                                    text-sm text-90
                                    leading-none
                                "
                                v-model="caption"
                            />
                        </div>

                        <div class="mt-4">
                            <label class="text-sm mb-1 ml-1 capitalize" v-text="__('credits')"></label>
                            <input
                                type="text"
                                class="
                                    form-input
                                    form-input-bordered
                                    px-2 py-1 w-full
                                    text-sm text-90
                                    leading-none
                                "
                                v-model="credits"
                            />
                        </div>

                        <div class="mt-4">
                            <label class="text-sm mb-1 ml-1 capitalize" v-text="__('ratio')"></label>
                            <select
                                class="
                                    form-input
                                    form-input-bordered
                                    px-2 py-1 w-full
                                    text-sm text-90
                                    leading-none
                                "
                                v-model="ratio"
                            >
                                <option 
                                    v-for="ratioOption in ratioOptions" 
                                    :key="ratioOption"
                                    :value="ratioOption"
                                    v-text="ratioOption"
                                />
                            </select>
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
                            v-text="__('update video')"
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
                @click="hideMenu"
            >
            </div>
        </div>
    </ContentBlockWrapper>
</template>

<script>

import ContentBlockWrapper from './ContentBlockWrapper';
import { nodeViewProps } from '@tiptap/vue-2';

export default {
    props: nodeViewProps,

    components: {
        ContentBlockWrapper
    },

    data() {
        return {
            menuIsActive: false,
            embedCode: '',
            caption: '',
            credits: '',
            ratio: '',
            ratioOptions: [
                '16:9',
                '4:3',
                '1:1',
                '9:16',
                '3:4',
                '2:1',
                '8:5',
            ]
        }
    },

    computed: {
        title() {
            let code = this.node.attrs.embedCode;

            if (!code || !code.substr('src=')) {
                return this.__('no embed code');
            }

            let url = code.substr((code.indexOf('src=') + 5));

            url = url.substr(0, url.indexOf('"'));

            let id = url.substr((url.lastIndexOf('/') + 1));

            if (id.indexOf('?') > -1) {
                id = id.substr(0, id.indexOf('?'));
            }

            const knownPlatforms = ['vimeo', 'youtube'];

            let title = '';
            _.each(knownPlatforms, function(knownPlatform){
                if (url.toLowerCase().indexOf(knownPlatform) > -1) {
                    title = _.upperFirst(knownPlatform)+' Video ('+id+')';
                }
            })

            if (!title) {
                title = url;

                if (title.lastIndexOf('?') > -1) {
                    title = title.substr(0, title.lastIndexOf('?'));
                }

                if (title.indexOf('//') > -1) {
                    title = title.substr(title.indexOf('//') + 2);
                }
            }

            return title;  
        }
    },

    methods: {
        showMenu() {
            this.embedCode = this.node.attrs.embedCode ? this.node.attrs.embedCode : '';
            this.caption = this.node.attrs.caption ? this.node.attrs.caption : '';
            this.credits = this.node.attrs.credits ? this.node.attrs.credits : '';
            this.ratio = this.node.attrs.ratio ? this.node.attrs.ratio : '16:9';
            
            this.menuIsActive = true;
        },

        update() {
            this.updateAttributes({
                embedCode: this.embedCode,
                caption: this.caption,
                credits: this.credits,
                ratio: this.ratio,
            });

            this.hideMenu();
        },

        hideMenu() {
            this.menuIsActive = false;
        },

        deleteBlock() {
            this.$el.remove();
        },

        __(str) {
            return str;
        }
    }
}
</script>
