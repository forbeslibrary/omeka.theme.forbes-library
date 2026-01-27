module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    less: {
      less: {
        files: {
          "css/style.css": "css/less/base.less"
        }
      }
    },

    compress: {
      main: {
        options: {
          archive: 'ForbesLibrary.zip',
          mode: 'zip'
        },
        files: [
          {
            src: ['**/*.@(css|ini|md|php)', '!css/less/**', '!node_modules/**'],
            dest: 'forbes-library'
          }
        ]
      }
    },

    watch: {
      scripts: {
        files: ['css/less/*.@(less|css)'],
        tasks: ['less'],
      },
    },
  });

  require("load-grunt-tasks")(grunt);

  // Default task(s).
  grunt.registerTask('default', ['less', 'compress']);

};
