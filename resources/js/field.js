window.pretty = require('pretty');
window._ = require('lodash');
window.axios = require('axios');

import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('detail-tiptap', DetailField)
  app.component('form-tiptap', FormField)
})
