
let mix = require('laravel-mix');

mix.setPublicPath('dist')
    .js('src/app.js', 'dist/app.js')
    .sass('src/app.scss', 'dist/app.css')
    .browserSync({
        proxy: {
            target: "localhost",
        },
        files: [
            "**/*.*",
        ],
        open: false,
        reloadOnRestart: true,
    }
);