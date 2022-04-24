let mix = require('laravel-mix')

mix.setPublicPath('dist')
    .js('resources/js/field.js', 'js').vue({ version: 3 })
    .webpackConfig({
        externals: {
            vue: 'Vue',
        },
        output: {
            uniqueName: 'vendor/package',
        }
    })
    .postCss('resources/css/tiptap.css', 'css')
    //.combine('node_modules/codemirror/theme/*.css', 'resources/css/codemirror-themes.css')
    ;
