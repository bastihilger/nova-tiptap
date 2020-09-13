window.pretty = require('pretty');

Nova.booting((Vue, router) => {
    Vue.component('detail-tiptap', require('./components/DetailField.vue').default);
    Vue.component('form-tiptap', require('./components/FormField.vue').default);
})
