let mix = require('laravel-mix')

mix.setPublicPath('dist')
    .js('resources/js/field.js', 'js')
    .sass('resources/sass/field.scss', 'css')
    .extend('transpileNodeModule', webpackConfig => {
        const { rules } = webpackConfig.module
        rules.filter(rule => rule.exclude && rule.exclude.toString() === '/(node_modules|bower_components)/')
            .forEach(rule => {
                rule.exclude = /node_modules\/(?!(prosemirror-tables|prosemirror-state|prosemirror-view|prosemirror-transform|prosemirror-utils)\/).*/
            })
    });
