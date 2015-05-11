module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    phplint: {
      php: ["**/*.php"],
    },

    less: {
      less: {
        files: {
          "css/style.css": "css/less/base.less"
        }
      }
    }
  });

  require("load-grunt-tasks")(grunt);

  // Default task(s).
  grunt.registerTask('default', ['phplint', 'less']);

};
