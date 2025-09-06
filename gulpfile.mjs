import gulp from 'gulp';
import * as sass from 'sass';
import gulpSass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';
import concat from 'gulp-concat';
import cleanCSS from 'gulp-clean-css';
import uglify from 'gulp-uglify';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import purgecss from 'gulp-purgecss';
import rtlcss from 'gulp-rtlcss';
import eslint from 'gulp-eslint';
import { deleteAsync } from 'del';
import browserSync from 'browser-sync';
import wrapper from 'gulp-wrapper';

// Load environment variables from .env file
import { config } from 'dotenv';
config();

const browserSyncInstance = browserSync.create();
const gulpSassInstance = gulpSass(sass);

// BrowserSync task
function serve(done) {
	browserSyncInstance.init({
		proxy: process.env.LOCAL_URL // Adjust this to your local WordPress URL
	});
	done();
}

// Clean task
function clean() {
	return deleteAsync(['dist']);
}

// Sass task
function sassTask() {
	return gulp
		.src('src/sass/style.scss')
		.pipe(sourcemaps.init())
		.pipe(
			gulpSassInstance({ outputStyle: 'compressed' }).on(
				'error',
				gulpSassInstance.logError
			)
		)
		.pipe(postcss([autoprefixer(), cssnano()]))
		.pipe(gulp.dest('./'))
		.pipe(browserSyncInstance.stream());
}

// PurgeCSS task
function purgeCSSTask() {
	return gulp
		.src('./style.css')
		.pipe(
			purgecss({
				content: ['**/*.php'],
				safelist: {
					standard: [
						'wp-post-image',
						'dark-mode-on',
						/^style-(.*)?$/,
						/^swiper-(.*)?$/,
						/^js-(.*)?$/,
						/^bg-(.*)?$/,
						/^layout-(.*)?$/,
						/^has-(.*)?$/,
						/^grid-(.*)?$/
					],
					deep: [
						// Match any string that ends with rtl
						/rtl$/,
						// Match any string that starts with lenis
						/^lenis/,
						/^wpml/,
						/^mfp/,
						// Match any string that starts with gform_ and has anything (or nothing) after it.
						/^gform_(.*)?$/,
						/^single-(.*)?$/,
						/^page-(.*)?$/,
						/^template-(.*)?$/,
						// Match any string containing header-nav anywhere
						/header-nav/,
						/dir-rtl/,
						/dir-ltr/
					],
					greedy: [],
					keyframes: true,
					variables: true
				}
			})
		)
		.pipe(gulp.dest('./'))
		.pipe(browserSyncInstance.stream());
}

// CSS RTL task
function rtlCssTask() {
	return gulp
		.src('./style.css')
		.pipe(rtlcss())
		.pipe(gulp.dest('./'))
		.pipe(browserSyncInstance.stream());
}

// JavaScript tasks
function pluginsJsTask() {
	return gulp
		.src('src/js/plugins/*.js')
		.pipe(sourcemaps.init())
		.pipe(concat('plugins.js'))
		.pipe(uglify())
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('./js'))
		.pipe(browserSyncInstance.stream());
}

function customJsTask() {
	return gulp
		.src('src/js/custom/**/*.js')
		.pipe(sourcemaps.init())
		.pipe(concat('custom.js'))
		.pipe(
			wrapper({
				header: 'document.addEventListener("DOMContentLoaded", function() {',
				footer: '});'
			})
		)
		.pipe(uglify())
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('./js'))
		.pipe(browserSyncInstance.stream());
}

function lintJS() {
	return gulp
		.src([
			'src/js/custom/*.js',
			'!src/js/!document.ready.js',
			'!src/js/Ιdocument.close.js'
		])
		.pipe(eslint())
		.pipe(eslint.format());
	// .pipe(eslint.failAfterError());
}

// Watch task
function watch() {
	gulp.watch('src/sass/**/*.{scss,sass}', gulp.series(sassTask));
	gulp.watch('src/js/**/*.js', gulp.series(jsTasks));
	gulp.watch([
		'*.html',
		'*.php',
		'js/**/*.js',
		'./style.css',
		'img/**/*.{png,jpg,jpeg,gif,webp,svg}'
	]).on('change', browserSyncInstance.reload);
}

// Define complex tasks
const jsTasks = gulp.series(pluginsJsTask, customJsTask);
const build = gulp.series(
	sassTask,
	gulp.parallel(purgeCSSTask, rtlCssTask, lintJS, jsTasks)
);
const dev = gulp.series(build, serve, watch);

// Export tasks
export {
	clean,
	sassTask as sass,
	purgeCSSTask as purgecss,
	rtlCssTask as rtlcss,
	jsTasks as js,
	lintJS,
	build
};
export default dev;
