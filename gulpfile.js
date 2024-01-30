/*
 |--------------------------------------------------------------------------
 | Gulp Asset Manager
 |--------------------------------------------------------------------------
 */

var gulp	  = require('gulp'),
    sass	  = require('gulp-sass'),
    cssnano   = require('gulp-cssnano'),
    concat	  = require('gulp-concat'),
    rename	  = require('gulp-rename'),
    uglify    = require('gulp-uglify');

gulp.task('sass', function() {
    gulp.src('resources/assets/sass/app.scss')
        .pipe(sass())
        .pipe(gulp.dest('public/assets/css'))
        .pipe(cssnano({discardComments: { removeAll: true } }))
        .pipe(rename('app.min.css'))
        .pipe(gulp.dest('public/assets/css'));
});

/*gulp.task('js', function() {
    gulp.src([
        'resources/js/jquery/dist/jquery.js',
        'resources/js/bootstrap-sass/assets/javascripts/bootstrap.js',
        'resources/js/file-style/bootstrap-filestyle.js',
        'resources/js/dropzone-js/dropzone.js',
        'resources/js/bootstrap-switcher/bootstrap-switch.js',
        'resources/js/jquery-form/jquery.form.js',
        'resources/js/tagsinput/jquery.tagsinput.js',
        'resources/assets/js/app.js'
    ])
        .pipe(concat('app.js'))
        .pipe(gulp.dest('public/assets/js'))
        .pipe(rename('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/assets/js'));
});*/

gulp.task('watch', function() {
    gulp.watch('resources/dependencies/*.scss', ['sass']);
    gulp.watch('resources/assets/sass/*.scss', ['sass']);
    gulp.watch('resources/assets/js/*.js', ['js']);
});

gulp.task('default', ['sass'], function() {});
