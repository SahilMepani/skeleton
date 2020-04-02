var compass = require( 'compass-importer' )
const sass = require( 'node-sass' );

module.exports = function ( grunt ) {

	grunt.initConfig( {

		watch: {
			sass: {
				files: [ 'sass/**/*.{scss,sass}', 'sass/_partials/**/*.{scss,sass}' ],
				tasks: [ 'sass' ]
			},
			js: {
				files: [ 'js/**/*.js' ],
				tasks: [ 'concat' ]
			},
			livereload: {
				files: [ '../*.html', '../*.php', '../js/**/*.{js,json}', '../*.css', '../img/**/*.{png,jpg,jpeg,gif,webp,svg}' ],
				options: {
					livereload: true
				}
			}
		},

		sass: {
			options: {
				sourceMap: true,
				implementation: sass,
				outputStyle: 'compact', // must be compact or expanded to avoid merge conflict in git and also for source maps to work
				importer: compass
			},
			dist: {
				files: {
					'../style.css': 'sass/style.scss'
				}
			}
		},

		concat: {
			options: {
				separator: ';\n'
			},
			plugin: {
				src: 'js/plugins/*.js',
				dest: '../js/plugins.js',
			},
			custom: {
				src: 'js/custom/*.js',
				dest: '../js/custom.js',
			},
		},

		uglify: {
			options: {
				output: {
					comments: 'false'
				}
			},
			dist: {
				files: [ {
					expand: true,
					src: [ '../js/plugins.js', '../js/custom.js' ],
					dest: '../js/',
				} ]
			}
		}

	} );

	grunt.loadNpmTasks( 'grunt-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	// grunt.loadNpmTasks( 'grunt-jquery-ready' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );

	grunt.registerTask( 'default', [ 'sass', 'concat', 'watch' ] );
	grunt.registerTask( 'uglify', [ 'uglify' ] );

};