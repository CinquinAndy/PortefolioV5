const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const THREE = require('three');

require('dotenv').config();

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your WordPlate applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JavaScript files.
 |
 */

const theme = process.env.WP_DEFAULT_THEME;

mix.setResourceRoot('../');
mix.setPublicPath(`public/themes/${theme}/assets`);

mix.js('resources/js/app.js', 'app.js')
  .sass('resources/sass/app.scss', 'app.css')
  .webpackConfig({
    module: {
      rules: [{
        test: /\.(frag|vert|glsl)$/,
        use: [
          {
            loader: 'glsl-shader-loader',
            options: {
              root:'/js/shaders'
            }
          }
        ]
      }]
    }
  })
  .options({
    postCss: [ tailwindcss('./tailwind.config.js') ],
  })
  .version();
