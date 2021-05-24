<template>
    <node-view-wrapper class="code-block">
        <div
            class="
                absolute right-32 top-2
                text-xs leading-none text-90 pt-2
            "
        >
            language:
        </div>
        <select 
            contenteditable="false" v-model="selectedLanguage"
            class="
                absolute right-0 top-3
                h-5 text-xs leading-none rounded-tr-sm rounded-tl-sm text-white pl-2
            "
        >
            <option :value="null">
            auto
            </option>
            <option disabled>
            —
            </option>
            <option v-for="(language, index) in languages" :value="language" :key="index">
                {{ language }}
            </option>
        </select>
        <pre><node-view-content as="code" /></pre>
    </node-view-wrapper>
</template>

<script>
import { NodeViewWrapper, NodeViewContent, nodeViewProps } from '@tiptap/vue-2';

export default {
    components: {
        NodeViewWrapper,
        NodeViewContent,
    },

    props: nodeViewProps,

    data() {
        return {
            languages: this.extension.options.lowlight.listLanguages(),
        }
    },

    computed: {
        selectedLanguage: {
            get() {
                return this.node.attrs.language
            },
            set(language) {
                this.updateAttributes({ language })
            },
        },
    },
}
</script>

<style lang="scss" scoped>
    .code-block {
        position: relative;
        padding-top: 15px;

        select {
            width: 122px;
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
            background: var(--90) url("data:image/svg+xml;utf8,<svg viewBox='0 0 140 140' width='12' height='12' xmlns='http://www.w3.org/2000/svg'><g><path d='m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z' fill='white'/></g></svg>") no-repeat;
            background-position: right 5px top 5px;
        }
    }
</style>
