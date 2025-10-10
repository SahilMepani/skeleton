import gulp from 'gulp';
import dartSass from 'sass';
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
import gulpIf from 'gulp-if'; // Added gulp-if
import { deleteAsync } from 'del';
import browserSync from 'browser-sync';
import wrapper from 'gulp-wrapper';

// Load environment variables from .env file
import { config } from 'dotenv';
config();

const browserSyncInstance = browserSync.create();
const sassCompiler = gulpSass(dartSass);
const isProduction = process.env.NODE_ENV === 'production';

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
		.pipe(gulpIf(!isProduction, sourcemaps.init())) // Sourcemaps only in dev
		.pipe(
			sassCompiler({
				outputStyle: isProduction ? 'compressed' : 'expanded' // Conditional output style
			}).on('error', sassCompiler.logError)
		)
		.pipe(
			postcss(
				isProduction
					? [autoprefixer(), cssnano()] // Prod plugins
					: [autoprefixer()] // Dev plugins (no cssnano)
			)
		)
		.pipe(gulpIf(!isProduction, sourcemaps.write('.'))) // Write sourcemaps only in dev
		.pipe(gulp.dest('./')) // Output to root for now
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
		.pipe(gulpIf(!isProduction, sourcemaps.init())) // Sourcemaps only in dev
		.pipe(concat('plugins.js'))
		.pipe(gulpIf(isProduction, uglify())) // Uglify only in prod
		.pipe(gulpIf(!isProduction, sourcemaps.write('.'))) // Write sourcemaps only in dev
		.pipe(gulp.dest('./js'))
		.pipe(browserSyncInstance.stream());
}

function customJsTask() {
	return gulp
		.src('src/js/custom/**/*.js')
		.pipe(gulpIf(!isProduction, sourcemaps.init())) // Sourcemaps only in dev
		.pipe(concat('custom.js'))
		.pipe(
			wrapper({
				header: 'document.addEventListener("DOMContentLoaded", function() {',
				footer: '});'
			})
		)
		.pipe(gulpIf(isProduction, uglify())) // Uglify only in prod
		.pipe(gulpIf(!isProduction, sourcemaps.write('.'))) // Write sourcemaps only in dev
		.pipe(gulp.dest('./js'))
		.pipe(browserSyncInstance.stream());
}

function lintJS() {
	// Keep linting in both modes for now
	return gulp
		.src([
			'src/js/custom/*.js'
			// '!src/js/!document.ready.js',
			// '!src/js/Ιdocument.close.js'
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

// Dev build sequence (no purgecss)
const buildDev = gulp.series(sassTask, gulp.parallel(lintJS, jsTasks));

// Prod build sequence (includes purgecss)
const buildProd = gulp.series(
	sassTask,
	gulp.parallel(rtlCssTask, lintJS, jsTasks), // Run JS/Lint in parallel with SCSS
	purgeCSSTask // Run PurgeCSS after initial CSS is built
);

const prod = gulp.series(buildProd, serve, watch);
const dev = gulp.series(buildDev, serve, watch);

// Export tasks
export {
	clean,
	sassTask as sass,
	purgeCSSTask as purgecss,
	rtlCssTask as rtlcss,
	jsTasks as js,
	lintJS,
	buildDev, // Export dev build
	buildProd // Export prod build
};

export default dev;
