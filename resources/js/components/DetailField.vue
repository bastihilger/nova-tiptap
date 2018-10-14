<template>
    <div class="tiptap-detail-field py-4">
        <truncate
            clamp="Show More"
            :length="200"
            less="Show Less"
            type="html"
            :text="field.value"
        >

        </truncate>
    </div>
</template>

<script>
import truncate from 'vue-truncate-collapsed'

export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],

    components: {
        truncate,
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

