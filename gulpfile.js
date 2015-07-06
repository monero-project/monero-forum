var gulp = require('gulp');
var concat = require('gulp-concat');
var minifyCss = require('gulp-minify-css');
var uglify = require('gulp-uglify');

gulp.task('minify-css', function() {
    return gulp.src('app/assets/css/*.css')
        .pipe(minifyCss({compatibility: 'ie8'}))
        .pipe(gulp.dest('app/assets/css/min'));
});

gulp.task('combine-css', ['minify-css'], function() {
    return gulp.src([
        'app/assets/css/min/bootstrap.css',
        'app/assets/css/min/bootstrap-markdown.css',
        'app/assets/css/min/jquery.dataTables.min.css',
        'app/assets/css/min/main.css',
        'app/assets/css/min/forum.css'])
        .pipe(concat('style.css'))
        .pipe(gulp.dest('./public'));
});

gulp.task('minify-js', function() {
    return gulp.src('app/assets/js/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('app/assets/js/min'));
});

gulp.task('combine-js', ['minify-js'], function() {
    return gulp.src([
        'app/assets/js/min/jquery.min.js',
        'app/assets/js/min/bootstrap.js',
        'app/assets/js/min/bootstrap-markdown.js',
        'app/assets/js/min/bootstrap.file-input.js',
        'app/assets/js/min/jquery.dataTables.min.js',
        'app/assets/js/min/jquery.infinitescroll.min.js',
        'app/assets/js/min/jquery.autosize.js',
        'app/assets/js/min/monero.js',
        'app/assets/js/min/posts.js',
        'app/assets/js/min/register.js'
    ])
        .pipe(concat('scripts.js'))
        .pipe(gulp.dest('./public'));
});

gulp.task('default', ['minify-css', 'combine-css', 'minify-js', 'combine-js']);

gulp.task('watch', function() {
    gulp.watch('app/assets/js/*.js', ['minify-js', 'combine-js']);
    gulp.watch('app/assets/css/*.css', ['minify-css', 'combine-css']);
});