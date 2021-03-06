const mix = require('laravel-mix');
const Dotenv = require('dotenv-webpack');

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

mix
    .webpackConfig({
        node: {
            fs: "empty"
        },
        plugins: [
            new Dotenv()
        ]
    })
    .browserSync({
        proxy: 'https://www.demo-postoj.crowdfundingtoolbox.news/moj-ucet',
        files: [
            'public/css/app.css',
            'public/js/app.js',
            'app/**/*',
            'routes/**/*',
            'resources/views/**/*',
            'resources/lang/**/*',
            'resources/sass/**/*',
            'resources/js/**/*'
        ]
    })
    .js('resources/js/app.js', 'public/js/')
    .sass('resources/sass/app.scss', 'public/css');


// const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
//
// mix.webpackConfig({
//     plugins: [
//         new BrowserSyncPlugin({
//             open: 'external',
//             host: 'localhost',
//             port: 3000,
//             proxy: 'http://127.0.0.1:8000/',
//             files: ['resources/views/**/*.php', 'app/**/*.php', 'routes/**/*.php']
//         })
//     ]
// })
//     .js('resources/js/app.js', 'public/js/')
//     .sass('resources/sass/app.scss', 'public/css/');
