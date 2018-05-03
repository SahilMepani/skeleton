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
				outputStyle: 'compact', // must be compact or expanded to avoid merge conflict in git.
				importer: compass
			},
			dist: {
				files: {
					'../style.css': 'sass/style.scss'
				}
			}
		},
		concat: {
	    plugin: {
	      src: ['js/plugins/*.js'],
	      dest: '../js/jquery.plugins.js',
	    },
	    custom: {
	      src: ['js/custom/*.js'],
	      dest: '../js/jquery.custom.js',
	    },
	  },
	  uglify: {
		  js: {
		    files: [{
		      expand: true,
		      src: ['../js/jquery.plugins.js', '../js/jquery.custom.js'],
		      dest: '../js/',
		    }]
		  }
		},
	});
	grunt.registerTask('default', ['sass:dist', 'concat', 'uglify', 'watch']);
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
};
