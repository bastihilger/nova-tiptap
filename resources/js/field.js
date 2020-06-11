window.pretty = require('pretty');

Nova.booting((Vue, router) => {
    Vue.component('index-tiptap', require('./components/IndexField'));
    Vue.component('detail-tiptap', require('./components/DetailField'));
    Vue.component('form-tiptap', require('./components/FormField'));
})

