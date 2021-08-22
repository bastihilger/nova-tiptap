let mix = require('laravel-mix')

mix.setPublicPath('dist')
    .js('resources/js/field.js', 'js').vue({ version: 2 })
    .sass('resources/sass/field.scss', 'css')
    //.combine('node_modules/codemirror/theme/*.css', 'resources/css/codemirror-themes.css')
    ;
