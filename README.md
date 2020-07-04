# Skeleton WP theme
Starter theme to help you jump start coding custom WordPress themes

## Setup
1. Clone the theme
2. Rename the theme folder to match the project name
3. Create a screenshot.png file of 1200 x 900 in the theme root
4. Create favicon.png and favicon.ico files in the theme root
5. Run ***node -v*** anywhere to check if you have Node.js installed in your system. If not, [Download Node.js](https://nodejs.org/en/) and install
6. Install grunt ***npm install grunt***
7. Go to theme source folder ***cd /path/to/your/wp-content/themes/theme-name/source***
8. Run the following command to install all the necessary packages to run grunt tasks ***npm install***
9. Update theme info in sass/style.scss file. Theme name should match the project name
  * Run the following command for grunt to compile all the scss/js files

  ***cd /path/to/your/wp-content/themes/skeleton/source***
  ***grunt***

  * All the scss files are created inside the source/sass/partials/ folder and its sub-folders. All the js files are divided into two folders source/js/plugins and source/js/custom. Grunt will compile all the source/sass/partials/.scss files into a single file named style.css and source/js/plugins/.js files into js/plugins.js file and source/js/custom/.js files into js/custom.js file
10. Make the Initial Commit