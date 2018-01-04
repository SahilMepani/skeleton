var compass = require('compass-importer')

module.exports = function(grunt) {
	grunt.initConfig({
		watch: {
			sass: {
				files: ['sass/**/*.{scss,sass}','sass/_partials/**/*.{scss,sass}'],
				tasks: ['sass:dist']
			},
			livereload: {
				files: ['../*.html', '../*.php', '../js/**/*.{js,json}', '../*.css','../img/**/*.{png,jpg,jpeg,gif,webp,svg}'],
				options: {
					livereload: true
				}
			}
		},
		sass: {
			options: {
				sourcemap: false,
				outputStyle: 'compact',
				importer: compass
			},
			dist: {
				files: {
					'../style.css': 'sass/style.scss'
				}
			}
		}
	});
	grunt.registerTask('default', ['sass:dist', 'watch']);
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
};
