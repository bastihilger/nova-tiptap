window.pretty = require('pretty');

Nova.booting((Vue, router) => {
    Vue.component('detail-tiptap', require('./components/DetailField'));
    Vue.component('form-tiptap', require('./components/FormField'));
})
