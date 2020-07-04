# Skeleton WP theme
Starter theme to help you jump start coding custom WordPress themes

## Setup
1. Download the master branch **DO NOT CLONE**
1. If present, **delete .git, .sass-cache, .php folders**
2. Rename the theme folder to match the project name
3. Create a theme screenshot.png file using screenshot.psd
4. Create favicon.png and favicon.ico files at the root
5. Run `node -v` in terminal/CMD to check if you have Node.js installed in your system. If not, [Download Node.js](https://nodejs.org/en/) and install
6. Install grunt <br> `npm install grunt`
7. Go to theme source folder <br> `cd /path/to/your/wp-content/themes/theme-name/source`
8. Install all the necessary packages to run grunt tasks <br> `npm install`
9. Update theme info in sass/style.scss file. Theme name should match the project name
10. Compile all the scss/js files using grunt<br>
`cd /path/to/your/wp-content/themes/theme-name/source` <br>
`grunt`<br>
All the scss files are created inside the source/sass/partials/ folder and its sub-folders. All the js files are divided into two folders source/js/plugins and source/js/custom. Grunt will compile all the source/sass/partials/.scss files into a file named style.css and source/js/plugins/.js files into js/plugins.js file and source/js/custom/.js files into js/custom.js file
11. Make the Initial Commit