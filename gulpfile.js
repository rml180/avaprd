var gulp = require('gulp')
var sass = require('gulp-sass')
var autoprefixer = require('gulp-autoprefixer')
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename')

var config = {
    srcCss : './_sass/**/*.scss',
    buildCss: './public/css'
}

gulp.task('sass', function(cb) {
    gulp.src(config.srcCss)

    // output non-minified CSS file
        .pipe(sass({
            outputStyle : 'expanded'
        }).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(gulp.dest(config.buildCss))

        // output the minified version
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest(config.buildCss))

    cb()
})

gulp.task('watch', function(cb) {
    gulp.watch(config.srcCss, ['sass'])
})

gulp.src(['node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js', 'node_modules/jquery/dist/jquery.min.js'])
    .pipe(gulp.dest('public/js'));


gulp.task('default', ['sass', 'watch'])