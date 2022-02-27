
let mix = require('laravel-mix');

mix.js('src/app.js', 'dist').setPublicPath('dist')
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