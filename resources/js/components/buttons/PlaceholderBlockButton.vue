<template>
    <span style="z-index: 10">
        <div
            class="
                fixed top-0 left-0
                w-full h-full
                flex items-center justify-center
            "
            style="z-index: 50"
            v-show="menuIsActive"
        >
            <div 
                class="rounded-lg shadow-lg overflow-hidden w-action-fields max-w-full"
                style="z-index: 20"
            >
                <div class="px-8 py-8 bg-white">
                    <p
                        v-text="__('which placeholder block do you want to add')+':'"
                        class="mb-4"
                    />
                    <div
                        class="max-h-search overflow-auto"
                    >
                        <div
                            v-for="block in field.placeholderBlocks"
                            :key="block.key"
                            class="mb-2"
                        >
                            <button
                                type="button"
                                class="btn btn-default btn-primary"
                                @click="addBlock(block)"
                                v-text="block.title"
                            >
                            </button>
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

        <span class="whitespace-nowrap">
            <base-button
                :isDisabled="mode != 'editor'"
                :clickMethod="showMenu"
                :icon="['far', 'cube']"
                :title="__('add placeholder')"
            >
                
            </base-button>
        </span>
    </span>
</template>

<script>
import BaseButton from './BaseButton.vue';

export default {
    props: [
        'button', 
        'editor',
        'field',
        'mode',
    ],

    data: function () {
        return {
            menuIsActive: false,
            blockKey: 'default',
        }
    },

    components: {
        BaseButton,
    },

    methods: {
        addBlock(block) {
            this.editor
                .chain()
                .focus()
                .insertContent('<placeholder-block data-key="'+block.key+'">'+block.title+'</placeholder-block>')
                .run();
            this.menuIsActive = false;
        },

        showMenu() {
            
            
            this.menuIsActive = true;
        },

        hideMenu() {
            this.menuIsActive = false;
        },
    }
}
</script>
