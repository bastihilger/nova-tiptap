<template>
    <!-- <codemirror 
        :value="value" 
        @input="updateValue"
        :options="cmOptions"
        class="border border-60 rounded-lg overflow-hidden"
    /> -->

    <Codemirror
        :value="modelValue"
        :options="cmOptions"
        border
        placeholder="test placeholder"
        :height="200"
        @change="updateValue"
    />
</template>

<script>
import Codemirror from "codemirror-editor-vue3";



// language
import "codemirror/mode/javascript/javascript.js";

// theme
import "codemirror/theme/dracula.css"

export default {
    props: {
        modelValue: String, 
        theme: String,
    },
    components: { Codemirror },
    data () {
        return {
            cmOptions: {
                tabSize: 4,
                mode: 'text/xml',
                theme: this.theme ? this.theme: 'dracula',
                lineNumbers: true,
                line: true,
            }
        }
    },
    methods: {
        updateValue: function (value) {
            this.$emit('update:modelValue', value)
            //this.$emit('input', value);
        }
    }
}
</script>
