## Skeleton WordPress theme
Starter theme to help you jump start coding awesome WordPress themes

### Initial Setup

1. [Download WordPress](https://wordpress.org/latest.zip) and install on your local server

1. [Download Theme](https://github.com/SahilMepani/skeleton/archive/refs/heads/blocks.zip) and move it inside *wp-content/themes/*

1. Rename the folder to match the **project name**

1. Run `node -v` anywhere in terminal to check if you have Node installed in your system. If not, [Download Node](https://nodejs.org/en/) and install

1. Install all the required packages
*cd /path/to/your/wp-content/themes/theme-name/source*
Run <br />`npm install`
`grunt`

> If you get an error ==grunt command not found==. Install grunt cli with the following command:
`npm install -g grunt-cli`
`grunt`

If everything went successful you should be able to see **Running watch task** in your terminal.

### Theme Activation

- Rename the downloaded theme folder to match your project name
- Create a theme screenshot.png[600x600]px file at the root.
- Create favicon.png and favicon.ico files at the root
- Update theme name and other details in sass/style.scss file
- cd *theme/source* and run `grunt`
- Activate the theme

### Development

You can compile all JS and CSS code by running `grunt` command from  *theme/source*

#### CSS

We use SASS for CSS development. All the sass files are created inside the *source/sass/partials/* folder and its sub-folders.

###### Creating a new SASS partial file

Add a new *_filename.scss* partial inside *source/sass/partials/* at the root or its appropriate folder and then import it inside *source/sass/_style.css* file.

*source/sass/_style.css* is the index file calling all the partials.

#### Javascript

All the JS files are created inside the *source/sass/js/plugins* and *source/sass/js/custom* folders and are compiled into a single file

###### Creating a new JS file

> . <br>All the js files are divided into two folders source/js/plugins and source/js/custom. <br>Grunt will compile all the source/sass/partials/.scss files into a file named style.css and source/js/plugins/.js files into js/plugins.js file and source/js/custom/.js files into js/custom.js file
<br>Run `grunt build` when pushing it to production

## Important Notes
	Always use rem units except for breakpoints and line-height. Avoid pixels.
