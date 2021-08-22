<template>
    <codemirror 
        v-bind:value="value" 
        @input="updateValue"
        :options="cmOptions"
        class="border border-60 rounded-lg overflow-hidden"
    />
</template>

<script>
import { codemirror } from 'vue-codemirror';

import 'codemirror/mode/xml/xml.js';
import 'codemirror/lib/codemirror.css';
import '../../css/codemirror-themes.css';

export default {
    props: ['value', 'theme'],
    components: { codemirror },
    data () {
        return {
            localValue: '<p>Fooo</p>',
            cmOptions: {
                tabSize: 4,
                mode: 'text/xml',
                theme: this.theme,
                lineNumbers: true,
                line: true,
            }
        }
    },
    methods: {
        updateValue: function (value) {
            this.$emit('input', value);
        }
    }
}
</script>
