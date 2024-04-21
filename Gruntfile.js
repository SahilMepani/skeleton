module.exports = function (grunt) {
	const sass = require('sass');

	const browserList = ['defaults'];

	const purgecssWordpress = require('purgecss-with-wordpress');

	grunt.initConfig({
		watch: {
			sass: {
				files: [
					'source/sass/**/*.{scss,sass}',
					'source/sass/_partials/**/*.{scss,sass}'
				],
				// dev
				// tasks: ['sass']
				// prod
				tasks: ['sass', 'stylelint', 'purgecss', 'rtlcss', 'postcss']
			},
			js: {
				files: ['source/js/**/*.js'],
				// dev
				tasks: ['concat']
				// prod
				// tasks: [ "eslint", "concat",  "babel", "uglify" ]
			},
			livereload: {
				files: [
					'*.html',
					'*.php',
					'js/**/*.{js,json}',
					'*.css',
					'img/**/*.{png,jpg,jpeg,gif,webp,svg}'
				],
				options: {
					livereload: true
				}
			}
		},

		// stylelint
		stylelint: {
			options: {
				cache: true, // Use caching to speed up linting
				configFile: '.stylelintrc.json',
				fix: true
			},
			src: [
				'source/sass/**/*.scss',
				'!source/sass/partials/js-plugins/**/*.scss',
				'!source/sass/partials/mixins/_rem.scss'
			]
		},

		// eslint
		eslint: {
			target: [
				'source/js/custom/**/*.js',
				'!source/js/custom/!document.ready.js',
				'!source/js/custom/Ιdocument.close.js'
			],
			options: {
				cache: true,
				fix: true
			}
		},

		// Frontend & Backend styles
		sass: {
			frontend: {
				options: {
					sourceMap: true,
					implementation: sass,
					outputStyle: 'expanded' // must be compact or expanded to avoid merge conflict in git and also for source maps to work
					// importer: compass
				},
				files: {
					'style.css': 'source/sass/style.scss'
				}
			}
			// backend: {
			// 	options: {
			// 		sourceMap: false,
			// 		implementation: sass,
			// 		// must be compact or expanded to avoid merge conflict in git and also for source maps to work
			// 		outputStyle: "compressed",
			// 		// importer: compass
			// 	},
			// 	files: {
			// 		"editor-style.css": "source/sass/style.scss",
			// 	},
			// },
		},

		// Frontend JS
		concat: {
			options: {
				separator: ';\n'
			},
			plugin: {
				src: ['source/js/plugins/*.js', 'source/js/custom/*.js'],
				dest: 'js/plugins.js'
			}
			// custom: {
			//   src: 'js/custom/*.js',
			//   dest: 'js/custom.js',
			// },
		},

		// Uglify
		uglify: {
			options: {
				output: {
					comments: 'false'
				}
			},
			dist: {
				files: [
					{
						expand: true,
						src: ['js/plugins.js'],
						dest: 'js/'
					}
				]
			}
		},

		// Purge CSS
		purgecss: {
			my_target: {
				options: {
					content: ['**/*.php'],
					safelist: {
						standard: [
							...purgecssWordpress.safelist,
							'wp-post-image',
							/^nav-(.*)?$/,
							/^pt-(.*)?$/,
							/^pb-(.*)?$/,
							/^swiper-(.*)?$/,
							/^js-(.*)?$/
						],
						deep: [/rtl$/, /^gform_(.*)?$/],
						greedy: [],
						keyframes: true,
						variables: true
					}
				},
				files: {
					'style.css': ['style.css']
				}
			}
		},

		// Post CSS
		postcss: {
			options: {
				processors: [
					require('postcss-merge-rules'),
					require('autoprefixer')({
						overrideBrowserslist: browserList
					}),
					require('cssnano')({
						preset: 'default'
					})
				]
			},
			dist: {
				src: ['style.css', 'style-rtl.css']
			}
		},

		// RTLCSS
		rtlcss: {
			myTask: {
				// task options
				options: {
					// generate source maps
					map: { inline: false },
					// rtlcss options
					opts: {
						clean: false
					},
					// rtlcss plugins
					plugins: [],
					// save unmodified files
					saveUnmodified: false
				},
				expand: false,
				cwd: '',
				dest: 'style-rtl.css',
				src: ['style.css']
			}
		},

		// Babel
		babel: {
			options: {
				sourceMap: true,
				presets: [
					[
						'@babel/preset-env',
						{
							targets: {
								browsers: browserList
							},
							modules: false
						}
					]
				]
			},
			dist: {
				files: {
					'js/plugins.js': 'js/plugins.js'
				}
			}
		}

		// Update Dev dependency
		// devUpdate: {
		//   main: {
		//       options: {
		//         updateType: 'prompt'
		//       }
		//   }
		// }
	});

	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-rtlcss');
	// grunt.loadNpmTasks('grunt-dev-update');
	// grunt.loadNpmTasks( 'grunt-jquery-ready' );
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('@lodder/grunt-postcss');
	grunt.loadNpmTasks('grunt-babel');
	grunt.loadNpmTasks('grunt-purgecss');
	grunt.loadNpmTasks('grunt-stylelint');
	grunt.loadNpmTasks('grunt-eslint');
	// grunt.loadNpmTasks('grunt-browser-sync');
	grunt.registerTask('default', ['watch']);
	// grunt.registerTask("build", [
	// 	"rtlcss",
	// 	"postcss",
	// 	"concat",
	// 	"babel",
	// 	"uglify",
	// ]);
	// grunt.registerTask( 'devUpdate', [ 'devUpdate' ] );
};
