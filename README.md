## Skeleton WordPress theme
Starter theme to help you jump start coding awesome WordPress themes

---
### Initial Setup
---

1. [Download WordPress](https://wordpress.org/latest.zip) and install on your local server

1. [Download Theme](https://github.com/SahilMepani/skeleton/archive/refs/heads/blocks.zip) and move it inside *wp-content/themes/*

1. Rename the folder to match the **project name**

1. Run `node -v` anywhere in terminal to check if you have Node installed in your system. If not, [Download Node](https://nodejs.org/en/) and install

1. Install all the required packages
*cd /path/to/your/wp-content/themes/theme-name/source*
Run <br />`npm i`
`grunt`

> <br />If you get an error ==grunt is not recognized==. Install grunt cli with the following command:
`npm i -g grunt-cli`
then restart the terminal
`grunt`
<br />

If everything went successful you should be able to see **Running watch task** in your terminal.

If the error still persists. Add the following path in your environment.
`C:\Users\your_username\AppData\Roaming\npm`

Backup the variables in your PATH (My Computer > right-click > Properties > Advanced system settings > Environment Variables > 'Edit' the 'Path' user variables for the current user, and copy the 'Variable value' and save it somewhere)

---
### Theme Activation
---

1. Rename the downloaded theme folder to match your project name
1. Create a theme screenshot.png[600x600]px file at the root.
1. Create favicon.png and favicon.ico files at the root
1. Update theme name and other details in sass/style.scss file
1. cd *theme/source* and run `grunt`
1. Activate the theme

---
### Development
---

You can compile all JS and CSS code by running `grunt` command from  *theme/source*

#### CSS

We use SASS for CSS development. All the sass files are created inside the *source/sass/partials/* folder and its sub-folders.

###### Creating a new SASS partial file

Add a new *_filename.scss* partial inside *source/sass/partials/* or its sub folders and then import it inside *source/sass/_style.css* file.

*source/sass/_style.css* is the index file calling all the partials.


###### Rules

- Never use px units. Always use rem unit. 10px = 1rem.

- Use utility/helper classes rather than writing custom css.

#### Javascript

All the JS files are created inside the *source/sass/js/plugins* and *source/sass/js/custom* folders and are compiled into a single file

###### Creating a new JS file

If you want to add a vendor/plugin, create a new file with the vendor/plugin name inside */source/js/plugins* folder.

To add custom coded js, create a new file with the appropriate_name.js inside */source/js/custom* folder.

Unlike, SASS partials this file don't have to be imported inside index file. They will automatically gets compiled into */js/plugins.js* file

---
#### Class/ID Naming Convention
---

All classes should be lowercase and separated by dash.

- Any design that covers the entire viewport should use the section tag and should be postfixed using section. e.g. *-section. Generally it sits outside the container.

		<section class="hero-slider">
			<div class="container">
			</div>
		</section>

- Any tag inside container that wrap elements should be postfixed using block. e.g *-block

		<div class="container">
			<div class="heading-block">
			</div>
		</div>

- Any tag inside section that wraps container should be called wrapper. It happens in very rare scenario.

		<section class="hero-slider">
			<div class="wrapper">
				<div class="container">
				</div>
			</div>
		</section>

- Any class/ID added using javascript should be prefixed using "js-" e.g. js-active, js-hidden

- Any class targeted with javascript should be prefixed using "js-" e.g. js-cards-slider

- Avoid ID as much as possible.

- Add a comment for every closing tag if it has multiple children.

		<section class="hero-slider">
			<div class="wrapper">
				<div class="container">
				</div>
			</div>
		</section> <!-- .hero-slider -->

Run `grunt build` when pushing it to production

---
### Important Notes
---

- Always use rem units except for breakpoints and line-height. Avoid pixels.
