import gulp from 'gulp';
import { exec } from 'child_process';
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';
import concat from 'gulp-concat';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import sortMediaQueries from 'postcss-sort-media-queries';
import purgecss from 'gulp-purgecss';
import rtlcss from 'gulp-rtlcss';
import eslint from 'gulp-eslint';
import gulpIf from 'gulp-if'; // Added gulp-if
import { deleteAsync } from 'del';
import browserSync from 'browser-sync';
import wrapper from 'gulp-wrapper';
import gulpEsbuild from 'gulp-esbuild';
import imagemin from 'gulp-imagemin';
import newer from 'gulp-newer';
import sharp from 'sharp';
import through from 'through2';
import { generate } from 'critical';

// Image optimization task
function imagesTask() {
	return gulp
		.src('src/images/**/*')
		.pipe(newer('images'))
		.pipe(imagemin())
		.pipe(gulp.dest('images'))
		.pipe(browserSyncInstance.stream());
}

// WebP generation task
function webpTask() {
	return gulp
		.src('src/images/**/*.{jpg,jpeg,png}')
		.pipe(newer({ extension: '.webp', dest: 'images' }))
		.pipe(
			through.obj(function (file, enc, cb) {
				if (file.isNull()) return cb(null, file);
				if (file.isStream())
					return cb(new Error('Streaming not supported'));

				sharp(file.contents)
					.webp()
					.toBuffer()
					.then(buffer => {
						file.contents = buffer;
						file.path = file.path.replace(
							/\.(jpg|jpeg|png)$/,
							'.webp'
						);
						cb(null, file);
					})
					.catch(err => cb(err));
			})
		)
		.pipe(gulp.dest('images'))
		.pipe(browserSyncInstance.stream());
}

// Critical CSS task
function criticalTask() {
	return generate({
		inline: false,
		base: './',
		src: process.env.LOCAL_URL,
		css: ['style.css'],
		target: {
			css: 'critical.css'
		},
		width: 1300,
		height: 900,
		extract: false,
		ignore: {
			atrule: ['@font-face'],
			decl: (node, value) => /url\(/.test(value)
		}
	});
}

// Swiper JS task using esbuild
function swiperJsTask() {
	return gulp
		.src('src/js/swiper-init.js')
		.pipe(
			gulpEsbuild({
				bundle: true,
				minify: isProduction,
				format: 'iife',
				sourcemap: !isProduction,
				outfile: 'swiper-bundle.js'
			})
		)
		.pipe(gulp.dest('./js'))
		.pipe(browserSyncInstance.stream());
}

// Load environment variables from .env file
import { config } from 'dotenv';
config();

const browserSyncInstance = browserSync.create();
const sassCompiler = gulpSass(dartSass);
const env = process.env.NODE_ENV?.trim() || 'local';
const isProduction = env === 'production';
console.log(`[Gulp] Running in ${env.toUpperCase()} mode`);

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
		.pipe(
			sassCompiler({
				outputStyle: isProduction ? 'compressed' : 'expanded', // Conditional output style
				includePaths: ['node_modules']
			}).on('error', sassCompiler.logError)
		)
		.pipe(
			postcss(
				isProduction
					? [autoprefixer(), sortMediaQueries(), cssnano()] // Prod plugins
					: [autoprefixer(), sortMediaQueries()] // Dev plugins (no cssnano)
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
				content: [
					'./*.php',
					'./templates/**/*.php',
					'./template-parts/**/*.php',
					'./acf-blocks/**/*.php',
					'./functions/**/*.php',
					'./src/js/**/*.js'
				],
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
						/dir-(rtl|ltr)/
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
		.pipe(gulpIf(!isProduction, sourcemaps.init()))
		.pipe(concat('plugins.js'))
		.pipe(
			gulpIf(
				isProduction,
				gulpEsbuild({
					minify: true
				})
			)
		)
		.pipe(gulpIf(!isProduction, sourcemaps.write('.')))
		.pipe(gulp.dest('./js'))
		.pipe(browserSyncInstance.stream());
}

function customJsTask() {
	return gulp
		.src('src/js/custom/**/*.js')
		.pipe(gulpIf(!isProduction, sourcemaps.init()))
		.pipe(concat('custom.js'))
		.pipe(
			wrapper({
				header: 'document.addEventListener("DOMContentLoaded", function() {',
				footer: '});'
			})
		)
		.pipe(
			gulpIf(
				isProduction,
				gulpEsbuild({
					minify: true
				})
			)
		)
		.pipe(gulpIf(!isProduction, sourcemaps.write('.')))
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

function lintCSS(done) {
	exec('npx stylelint "src/sass/**/*.scss"', (err, stdout, stderr) => {
		if (stdout) console.log(stdout);
		if (stderr) console.error(stderr);
		done(); // Don't fail the task on lint errors to keep the process running
	});
}

// Watch task
function watch() {
	gulp.watch('src/sass/**/*.{scss,sass}', gulp.series(sassTask));
	gulp.watch('src/js/swiper-init.js', gulp.series(swiperJsTask));
	gulp.watch('src/js/**/*.js', gulp.series(jsTasks));
	gulp.watch('src/images/**/*', gulp.series(imagesTask, webpTask));
	gulp.watch([
		'*.html',
		'*.php',
		'js/**/*.js',
		'img/**/*.{png,jpg,jpeg,gif,webp,svg}'
	]).on('change', browserSyncInstance.reload);
}

// Define complex tasks
const jsTasks = gulp.series(swiperJsTask, pluginsJsTask, customJsTask);
const imgTasks = gulp.series(imagesTask, webpTask);

// Dev build sequence (no purgecss)
const buildDev = gulp.series(
	gulp.parallel(sassTask, imgTasks),
	gulp.parallel(lintJS, jsTasks)
);

// Prod build sequence (includes purgecss)
const buildProd = gulp.series(
	gulp.parallel(sassTask, imgTasks),
	gulp.parallel(rtlCssTask, lintJS, jsTasks), // Run JS/Lint in parallel with SCSS
	purgeCSSTask, // Run PurgeCSS after initial CSS is built
	criticalTask // Generate critical CSS last
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
	imagesTask as images,
	webpTask as webp,
	criticalTask as critical,
	lintJS,
	lintCSS,
	buildDev, // Export dev build
	buildProd, // Export prod build
	prod,
	dev
};

export default isProduction ? prod : dev;
