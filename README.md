# Skeleton WP theme
Starter theme to help you jump start coding awesome WordPress themes

## Setup
- Download the **MASTER** branch. **DO NOT CLONE**
- Rename the theme folder to match the project name
- Create a theme screenshot.png file using screenshot.psd
- Create favicon.png and favicon.ico files at the root
- Run `node -v` anywhere in terminal to check if you have Node.js installed in your system. If not, [Download Node.js](https://nodejs.org/en/) and install
- Install all the required packages <br>
`cd /path/to/your/wp-content/themes/theme-name/source` <br>
`npm install`
- Update theme name, theme URI and description in sass/style.scss file
- Compile all the sass and js files using grunt<br>
`cd /path/to/your/wp-content/themes/theme-name/source` <br>
`grunt`<br><br>
> All the sass files are created inside the source/sass/partials/ folder and its sub-folders. <br>All the js files are divided into two folders source/js/plugins and source/js/custom. <br>Grunt will compile all the source/sass/partials/.scss files into a file named style.css and source/js/plugins/.js files into js/plugins.js file and source/js/custom/.js files into js/custom.js file

## Important Notes
	Always use rem units except for breakpoints and line-height. Avoid pixels.