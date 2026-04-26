import gulp from 'gulp';
import { exec } from 'child_process';
import * as dartSass from 'sass-embedded';
import gulpSass from 'gulp-sass';
import concat from 'gulp-concat';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import sortMediaQueries from 'postcss-sort-media-queries';
import purgecss from 'gulp-purgecss';
import rtlcss from 'gulp-rtlcss';
import gulpIf from 'gulp-if';
import terser from 'gulp-terser';
import { deleteAsync } from 'del';
import browserSync from 'browser-sync';
import gulpEsbuild from 'gulp-esbuild';
import through from 'through2';
import { generate } from 'critical';

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
		.pipe(gulp.dest('./assets/js'))
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
	let stream = gulp.src('src/sass/style.scss').pipe(
		sassCompiler({
			outputStyle: isProduction ? 'compressed' : 'expanded',
			includePaths: ['node_modules']
		}).on('error', sassCompiler.logError)
	);

	if (isProduction) {
		stream = stream.pipe(
			postcss([autoprefixer(), sortMediaQueries(), cssnano()])
		);
	}

	return stream.pipe(gulp.dest('./')).pipe(browserSyncInstance.stream());
}

// Block Sass task - compiles individual block SCSS files
function blockSassTask() {
	let stream = gulp
		.src('blocks/**/*.scss', { since: gulp.lastRun(blockSassTask) })
		.pipe(
			sassCompiler({
				outputStyle: isProduction ? 'compressed' : 'expanded',
				includePaths: ['node_modules']
			}).on('error', sassCompiler.logError)
		);

	if (isProduction) {
		stream = stream.pipe(
			postcss([autoprefixer(), sortMediaQueries(), cssnano()])
		);
	}

	return stream.pipe(gulp.dest('blocks')).pipe(browserSyncInstance.stream());
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
					'./blocks/**/*.php',
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
		.pipe(concat('plugins.js'))
		.pipe(gulpIf(isProduction, terser()))
		.pipe(gulp.dest('./assets/js'))
		.pipe(browserSyncInstance.stream());
}

function customJsTask() {
	return gulp
		.src('src/js/custom/**/*.js')
		.pipe(concat('custom.js'))
		.pipe(
			through.obj(function (file, enc, cb) {
				if (file.isNull()) return cb(null, file);
				if (file.isStream())
					return cb(new Error('Streaming not supported'));

				const header =
					'document.addEventListener("DOMContentLoaded", function() {';
				const footer = '});';
				file.contents = Buffer.concat([
					Buffer.from(header + '\n'),
					file.contents,
					Buffer.from('\n' + footer)
				]);
				cb(null, file);
			})
		)
		.pipe(gulpIf(isProduction, terser()))
		.pipe(gulp.dest('./assets/js'))
		.pipe(browserSyncInstance.stream());
}

function lintJS(done) {
	// Use ESLint via CLI instead of gulp-eslint
	exec('npx eslint "src/js/custom/**/*.js"', (err, stdout, stderr) => {
		if (stdout) console.log(stdout);
		if (stderr) console.error(stderr);
		done(); // Don't fail the task on lint errors
	});
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
	const watchOpts = { usePolling: true, interval: 500 };
	gulp.watch('src/sass/**/*.{scss,sass}', watchOpts, gulp.series(sassTask));
	gulp.watch('blocks/**/*.scss', watchOpts, gulp.series(blockSassTask));
	gulp.watch('src/js/swiper-init.js', watchOpts, gulp.series(swiperJsTask));
	gulp.watch('src/js/**/*.js', watchOpts, gulp.series(jsTasks));
	gulp.watch(
		[
			'*.html',
			'*.php',
			'blocks/**/*.php',
			'templates/**/*.php',
			'template-parts/**/*.php',
			'functions/**/*.php',
			'assets/js/**/*.js',
			'assets/images/**/*.{png,jpg,jpeg,gif,webp,svg}'
		],
		watchOpts
	).on('change', browserSyncInstance.reload);
	gulp.watch('blocks/**/*.js', watchOpts).on(
		'change',
		browserSyncInstance.reload
	);
}

// Define complex tasks
const jsTasks = gulp.series(swiperJsTask, pluginsJsTask, customJsTask);

// Dev build sequence (no purgecss)
const buildDev = gulp.series(
	gulp.parallel(sassTask, blockSassTask),
	gulp.parallel(lintJS, jsTasks)
);

// Prod build sequence (includes purgecss)
const buildProd = gulp.series(
	gulp.parallel(sassTask, blockSassTask),
	gulp.parallel(rtlCssTask, lintJS, jsTasks) // Run JS/Lint in parallel with SCSS
	// purgeCSSTask, // Run PurgeCSS after initial CSS is built
	// criticalTask // Generate critical CSS last
);

const prod = gulp.series(buildProd, serve, watch);
const dev = gulp.series(buildDev, serve, watch);

// Export tasks
export {
	clean,
	sassTask as sass,
	blockSassTask as blockSass,
	purgeCSSTask as purgecss,
	rtlCssTask as rtlcss,
	jsTasks as js,
	criticalTask as critical,
	lintJS,
	lintCSS,
	buildDev, // Export dev build
	buildProd, // Export prod build
	prod,
	dev
};

export default isProduction ? prod : dev;
