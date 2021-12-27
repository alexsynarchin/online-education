const mix = require('laravel-mix');
let distPath = 'public/assets/admin';
require('laravel-mix-alias');
mix
    .setPublicPath(distPath)
    .js('resources/admin/js/app.js', 'js')
    .vue({ version: 2 })
    .sass('resources/admin/scss/app.scss', 'css')
    .options({
        processCssUrls: false,
        processJsUrls:false
    })
    .webpackConfig({
        resolve: {
            extensions: ['.js', '.vue', '.json', '.styl','.scss','.css'],
            alias: {
                '@': __dirname + '/resources',
            },
        },
    })
    .sourceMaps()
    .setPublicPath(distPath)
    .setResourceRoot("/")

    .version();
