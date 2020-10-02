<template>
    <panel-item :field="field">
        <template slot="value">
            <div class="tiptap-detail-field">
                <excerpt
                    :content="parsedValue"
                    :plain-text="true"
                    :should-show="field.shouldShow"
                />
            </div>
        </template>
    </panel-item>
</template>

<script>

export default {
    props: {
        field: {
            type: Object,
            required: true,
        },
    },
    computed: {
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

.tiptap-detail-field p, .tiptap-detail-field ul, .tiptap-detail-field ol, .tiptap-detail-field blockquote, .tiptap-detail-field pre {
    margin-bottom: 0.7em;
}

.tiptap-detail-field li > p {
    display: inline;
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
