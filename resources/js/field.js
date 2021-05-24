window.pretty = require('pretty');
window._ = require('lodash');

Nova.booting((Vue, router) => {
    Vue.component('detail-tiptap', require('./components/DetailField.vue').default);
    Vue.component('form-tiptap', require('./components/FormField.vue').default);
})
