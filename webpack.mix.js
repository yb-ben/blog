const mix = require('laravel-mix');

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

/*mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');*/



Mix.listen('configReady', (webpackConfig) => {
    // Exclude 'svg' folder from font loader
    let fontLoaderConfig = webpackConfig.module.rules.find(rule => String(rule.test) === String(/(\.(png|jpe?g|gif|webp)$|^((?!font).)*\.svg$)/));
    fontLoaderConfig.exclude = /(resources\/backend\/icons)/;
});

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/backend'),
        },
    },
    module: {
        rules: [
            {
                test: /\.svg$/,
                loader: 'svg-sprite-loader',
                include: [path.resolve(__dirname, 'resources/backend/icons/svg')],
                options: {
                    symbolId: 'icon-[name]'
                }
            }
        ],
    }
}).babelConfig({
    plugins: ['dynamic-import-node']
});

mix.js('resources/index/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .extract(['vue','axios']);

mix.js('resources/backend/main.js', 'public/js');

if (mix.inProduction()) {
    mix.version();
}
