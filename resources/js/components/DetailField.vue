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
                :text="parsedValue"
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

        parsedValue() {
            var pattern = /<iframe.*?\/iframe>/gm;
            var parsedValue = this.field.value.replace(pattern, '<div class="tiptap-detail-iframe">iframe</div>');

            pattern = /<script.*?\/script>/gm;
            parsedValue = parsedValue.replace(pattern, '');

            return parsedValue;
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

.tiptap-detail-iframe {
    background-color: #fafafa;
    border: 1px dotted #ddd;
    padding: 12px;
    text-align: center;
    margin: 5px 0;
    text-transform: uppercase;
    font-size: 0.9em;
    line-height: 1;
    color: #aaa;
}
</style>

