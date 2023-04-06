'use strict';

let gulp         = require('gulp'), // Подключаем Gulp
    browserSync  = require('browser-sync').create(),// Подключаем Browser Sync
    sass         = require('gulp-sass')(require('sass')), // Подключаем Sass пакет
    nodeBourbon  = require('node-bourbon'), // Подключаем библиотеку Sass миксинов
    rename       = require('gulp-rename'), // Подключаем библиотеку для переименования файлов
    autoprefixer = require('gulp-autoprefixer'), // Подключаем библиотеку для автоматического добавления префиксов
    cleanCSS     = require('gulp-clean-css');


sass.compiler = require('node-sass');


function styles() {
    return gulp.src("sass/**/*.sass")
        // перегоняем sass в css
        .pipe(sass({
            includePaths: nodeBourbon.includePaths
        }).on('error', sass.logError))
        // переименовываем файл
        .pipe(rename({suffix: ".min", prefix : ""}))
        // добавляем свойсва в css для популярных браузеров
        .pipe(autoprefixer({
            cascade: false
        }))
        // сжимаем css
        .pipe(cleanCSS({
            level: 2
        }))
        // кладём в папку
        .pipe(gulp.dest("../app/web/front/css"))
        // перезагрузка станицы
        .pipe(browserSync.stream());
}


function watch() {
    browserSync.init({
        port: 1321,
        ui: {
            port: 1322
        },
        proxy: 'projectvint.dev.ru',
        notify: false // Отключаем уведомления
    });

    gulp.watch("./sass/**/*.sass", styles);

    gulp.watch("../app/web/*.php").on('change', browserSync.reload);
    gulp.watch("../app/web/*.html").on('change', browserSync.reload);

    gulp.watch("../app/assets/*.php").on('change', browserSync.reload);
    gulp.watch("../app/config/*.php").on('change', browserSync.reload);
    gulp.watch("../app/controller/*.php").on('change', browserSync.reload);
    gulp.watch("../app/entities/*.php").on('change', browserSync.reload);
    gulp.watch("../app/forms/*.php").on('change', browserSync.reload);
    gulp.watch("../app/services/*.php").on('change', browserSync.reload);
    gulp.watch("../app/repositories/*.php").on('change', browserSync.reload);
    gulp.watch("../app/view/*.php").on('change', browserSync.reload);
    gulp.watch("../app/widgets/*.php").on('change', browserSync.reload);
    gulp.watch("../app/messages/*.php").on('change', browserSync.reload);
}


gulp.task(
    'default',
    gulp.series(styles, watch)
);
