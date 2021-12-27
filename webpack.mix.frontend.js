const mix = require('laravel-mix');
let distPath = 'public/assets/site';
const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');
require('laravel-mix-alias');
mix
    .js('resources/site/js/app.js', 'js')
    .vue({ version: 2 })
    .sass('resources/site/scss/app.scss', 'css')
    .options({
        processCssUrls: false,
        processJsUrls:false
    })

    .webpackConfig({
        plugins: [
            new SVGSpritemapPlugin('resources/site/svg/*.svg',{
                output:{
                    filename:'images/sprites.svg'
                }
            }),
        ],
        resolve: {
            extensions: ['.js', '.vue', '.json', '.styl','.scss','.css'],
            alias: {
                '@': __dirname + '/resources',
            },
        },
    })
    .sourceMaps()
    .setPublicPath(distPath)
    .setResourceRoot("/assets/site/")
    .version();
