const mix = require('laravel-mix');
const glob = require('glob-all')
const purgeCss = require('purgecss-webpack-plugin')

require('laravel-mix-tailwind');
//require('./postCssConfig');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.options({
    extractVueStyles: '/css/vue.css'
});

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css')
    .tailwind('./tailwind.config.js')
    .extract(['vue', 'vue-chartjs', 'vue2-leaflet']);

if (mix.inProduction()) {
    mix
        .version();
}
