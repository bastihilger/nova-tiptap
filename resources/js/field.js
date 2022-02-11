window.pretty = require('pretty');
window._ = require('lodash');
window.axios = require('axios');

Nova.booting((Vue, router) => {
    

    Vue.component('detail-tiptap', require('./components/DetailField.vue').default);
    Vue.component('form-tiptap', require('./components/FormField.vue').default);
})

if (typeof Nova.config.novaTiptap === 'object') {
    if (typeof Nova.config.novaTiptap.translations === 'object') {
        Object.assign(Nova.config.translations, Nova.config.novaTiptap.translations)
    }
}
