<template>
    <div class="tiptap-index-field py-4">
        <truncate
            clamp="Show More"
            :length="200"
            less="Show Less"
            type="html"
            :text="parsedValue"
        >

        </truncate>
    </div>
</template>



<script>
import truncate from 'vue-truncate-collapsed'

export default {
    props: ['resourceName', 'field'],

    components: {
        truncate,
    },

    computed: {
        parsedValue() {
            var pattern = /<iframe.*?\/iframe>/gm;
            var parsedValue = this.field.value.replace(pattern, '<div class="tiptap-index-iframe">iframe</div>');

            pattern = /<script.*?\/script>/gm;
            parsedValue = parsedValue.replace(pattern, '');

            return parsedValue;
        }
    },
}
</script>

<style>
.tiptap-index-field h1, .tiptap-index-field h2, .tiptap-index-field h3, .tiptap-index-field h4, .tiptap-index-field h5, .tiptap-index-field h6 {
    font-size: 1em;
    margin-bottom: 0.35em;
}

.tiptap-index-field a {
    color: var(--primary);
}

.tiptap-index-field p, ul, ol, blockquote, pre {
    margin-bottom: 0.7em;
}

.tiptap-index-iframe {
    background-color: #fafafa;
    border: 1px dotted #ddd;
    padding: 4px;
    text-align: center;
    margin: 5px 0;
    text-transform: uppercase;
    font-size: 0.7em;
    line-height: 1;
    color: #aaa;
}
</style>

