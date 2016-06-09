// Include gulp
var gulp = require('gulp'); 

// Include Our Plugins
var jshint = require('gulp-jshint')
,   watch = require('gulp-watch')
,	concat = require('gulp-concat')
,	uglify = require('gulp-uglify')
,	rename = require('gulp-rename')
,	concatCss = require('gulp-concat-css')
,	minifyCSS = require('gulp-minify-css')
,	imagemin = require('gulp-imagemin')
,	cache = require('gulp-cache');
var plumber = require('gulp-plumber'); 
var notify = require('gulp-notify');
var sass = require('gulp-sass');

var plumberErrorHandler = { 
    errorHandler: notify.onError({
        title: 'Gulp',
        message: 'Error: <%= error.message %>'
      })
};

var paths = {
	scripts: [
		'../public/js/libs/jquery-1.11.3.min.js',
		'../public/js/script.js',
	],
	styles: [
		'../public/css/reset.css',
		'../public/icomoon/style.css',
		'../public/css/style.css',
	],
	dest:"../public/dist",
	images:"../public/images"
};

// Lint Task
gulp.task('lint', function() {
	return gulp.src(paths.scripts)
        .pipe(plumber(plumberErrorHandler))
		.pipe(jshint())
		.pipe(jshint.reporter('default'));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
	return gulp.src(paths.scripts)
        .pipe(plumber(plumberErrorHandler))
		.pipe(concat('all.js'))
		.pipe(gulp.dest(paths.dest+'/js'))
		.pipe(rename('all.min.js'))
		.pipe(uglify({ mangle: false }))
		.pipe(gulp.dest(paths.dest+'/js'));
});
// Concatenate JS
gulp.task('scripts-dev', function() {
	return gulp.src(paths.scripts)
        .pipe(plumber(plumberErrorHandler))
		.pipe(concat('all.js'))
		.pipe(gulp.dest(paths.dest+'/js'))
		.pipe(rename('all.min.js'))
		// .pipe(uglify({ mangle: false }))
		.pipe(gulp.dest(paths.dest+'/js'));
});

// Concatenate & Minify CSS
gulp.task('css', function () {
	return gulp.src(paths.styles)
        .pipe(plumber(plumberErrorHandler))
		.pipe(concatCss("css/style.css"))
		.pipe(gulp.dest(paths.dest+'/'))
		.pipe(rename("/css/style.min.css"))
		.pipe(minifyCSS({}))
		.pipe(gulp.dest(paths.dest+'/'));
});

// Concatenate CSS
gulp.task('css-dev', function () {
	return gulp.src(paths.styles)
        .pipe(plumber(plumberErrorHandler))
		.pipe(concatCss("css/style.css"))
		.pipe(gulp.dest(paths.dest+'/'))
		.pipe(rename("/css/style.min.css"))
		// .pipe(minifyCSS({}))
		.pipe(gulp.dest(paths.dest+'/'));
});

gulp.task('images', function() {
  return gulp.src(paths.images+'/**/*')
        .pipe(plumber(plumberErrorHandler))
    .pipe(cache(imagemin({ optimizationLevel: 5, progressive: true, interlaced: true })))
    .pipe(gulp.dest(paths.dest+'/images'));
});

// Watch Files For Changes
gulp.task('watch', function() {
	gulp.watch(paths.scripts, ['scripts']);
	gulp.watch(paths.styles, ['css']);
});
// Watch Files For Changes
gulp.task('watch-dev', function() {
	gulp.watch(paths.scripts, ['scripts-dev']);
	gulp.watch(paths.styles, ['css-dev']);
	watch(paths.images+'/**/*', function() {
        gulp.start('images');
    });
});

gulp.task('sass', function () {
    return gulp.src('../web/sass/style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('../web/dist'));
});

// Default Task
gulp.task('default', ['scripts', 'css', 'images', 'watch']);
// dev Task
gulp.task('dev', ['scripts-dev', 'css-dev', 'images', 'watch-dev']);

gulp.task('delivery', ['scripts', 'css', 'images']);