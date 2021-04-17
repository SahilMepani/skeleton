module.exports = function ( grunt ) {

  // const compass = require( 'compass-importer' );
  // https://github.com/sindresorhus/grunt-sass
  const Fiber = require('fibers');
  const sass  = require( 'node-sass' );

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

    // Frontend & Backend styles
    sass: {
      frontend: {
        options: {
          sourceMap: true,
          implementation: sass,
          fiber: Fiber,
          outputStyle: 'expanded', // must be compact or expanded to avoid merge conflict in git and also for source maps to work
          // importer: compass
        },
        files: {
          '../style.css': 'sass/style.scss',
        }
      },
      backend: {
        options: {
          sourceMap: false,
          implementation: sass,
          fiber: Fiber,
          outputStyle: 'compressed', // must be compact or expanded to avoid merge conflict in git and also for source maps to work
          // importer: compass
        },
        files: {
          '../editor-style.css': 'sass/style.scss',
        }
      }
    },

    // Frontend JS
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
    },

    // Post CSS
    postcss: {
      options: {
        processors: [
          require('autoprefixer')(),
        ]
      },
      dist: {
        src: '../*.css'
      }
    }

  } );

  grunt.loadNpmTasks( 'grunt-sass' );
  grunt.loadNpmTasks( 'grunt-contrib-watch' );
  grunt.loadNpmTasks( 'grunt-contrib-concat' );
  // grunt.loadNpmTasks( 'grunt-jquery-ready' );
  grunt.loadNpmTasks( 'grunt-contrib-uglify' );
  grunt.loadNpmTasks('@lodder/grunt-postcss');
  grunt.registerTask( 'default', [ 'sass', 'concat', 'postcss', 'watch'  ] );
  // grunt.registerTask( 'uglify', [ 'uglify' ] );

};