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

// resources/js/app.jsがトランスパイルされて、トランスパイル後のファイルがpublic/jsディレクトリに同じapp.jsというファイル名で保存される
// ブラウザに実際に読み込ませて使うJavaScriptは、public/js/app.jsのほうになる
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version();
