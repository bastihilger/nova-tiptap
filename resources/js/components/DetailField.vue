<template>
    <div class="flex">
        <div class="w-1/4 py-4">
            <h4 class="font-normal text-80">
                {{ label }}
            </h4>
        </div>

        <div class="tiptap-detail-field w-3/4 py-4">
            <truncate
                clamp="Show More"
                :length="200"
                less="Show Less"
                type="html"
                :text="field.value"
            >

            </truncate>
        </div>
    </div>
</template>

<script>
import truncate from 'vue-truncate-collapsed'

export default {
    components: {
        truncate,
    },

    props: {
        field: {
            type: Object,
            required: true,
        },
        fieldName: {
            type: String,
            default: '',
        },
    },
    computed: {
        label() {
            return this.fieldName || this.field.name
        },
    },
}
</script>

<style>
.tiptap-detail-field h1, .tiptap-detail-field h2, .tiptap-detail-field h3, .tiptap-detail-field h4, .tiptap-detail-field h5, .tiptap-detail-field h6 {
    font-size: 1em;
    margin-bottom: 0.35em;
}

.tiptap-detail-field a {
    color: var(--primary);
}

.tiptap-detail-field p, ul, ol, blockquote, pre {
    margin-bottom: 0.7em;
}
</style>

