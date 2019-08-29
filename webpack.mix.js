let mix = require('laravel-mix');

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


const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin
const webpack = require('webpack')


mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')

/*minute 1:53:35 grafikart*/

    .webpackConfig({
        plugins: [
            new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /fr/),
            new BundleAnalyzerPlugin({
                open: false
            })
        ]
    })
