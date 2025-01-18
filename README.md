## Initial Setup

-   [Download WordPress](https://wordpress.org/latest.zip) and install it on your local server
-   [Download the Theme](https://github.com/SahilMepani/skeleton/archive/refs/heads/blocks.zip) and move it inside _wp-content/themes/_
-   Rename the folder to match **“five-palm-hr”**
-   Run `node -v` anywhere in the terminal to check if you have Node installed in your system. If not, [Download Node](https://nodejs.org/en/) and install
-   Install all the required packages

```powershell
cd /path/to/your/wp-content/themes/theme-name
npm i --force
npm start
```

-   If you get an error grunt is not recognized. Install grunt-cli with the following command:

```powershell
npm i -g grunt-cli
# restart
npm start
```

If everything went successfully you should be able to see the **Running watch task** in your terminal.

![Untitled](https://s3-us-west-2.amazonaws.com/secure.notion-static.com/d34ac045-01b2-46b6-bfd7-da063ae82694/Untitled.png)

If the error still persists. Add the following path to your environment.

```powershell
C:\\Users\\YOUR_USERNAME\\AppData\\Roaming\\npm
```

Backup the variables in your PATH (My Computer > right-click > Properties > Advanced system settings > Environment Variables > 'Edit' the 'Path' user variables for the current user, and copy the 'Variable value' and save it somewhere)

---

## Theme Activation

1. Rename the downloaded theme folder to match your project name
2. Create a theme screenshot.png [600x600]px file at the root.
3. Create favicon.png and favicon.ico files at the root
4. Update theme name and other details in sass/style.scss file
5. cd _theme_ and run `npm start`
6. Activate the theme

---

## VS Code - Formatting

1. **Install extensions**

-   EditorConfig for VS Code
-   ESLint
-   Formatting Toggle
-   PHP Sniffer & Beautifier
-   PostCSS Sorting
-   Prettier - Code Formatter
-   Stylelint
-   Auto Align
-   Intellicode
-   PHP Intelephense
-   SASS (.sass only)
-   SCSS IntelliSense
-   WordPress Hooks Intellisense

1. **Install PHPCS package in your machine**

```bash
# phpcs
composer global require squizlabs/php_codesniffer
# wpcs and others
composer g require --dev automattic/vipwpcs dealerdirect/phpcodesniffer-composer-installer
```

1. \*\*Add the PHPCS to the global PATH(environment variable) on your system

Windows - PowerShell**
Most probably your PHPCS executable files will be stored in the below folder. But confirm below adding it to the path. **Take a backup of existing environment variables below running the command please\*\*

```powershell
[System.Environment]::SetEnvironmentVariable("PATH", $env:PATH + ";C:\Users\YOUR_USERNAME\AppData\Roaming\Composer\vendor\bin", [System.EnvironmentVariableTarget]::User)
```

To verify that the PATH variable has been set correctly, type:

```
echo $Env:PATH
```

**Mac - Terminal**

```powershell
# open the file
nano ~/.bash_profile
# add the path
export PATH="$PATH:/User/YOUR_USERNAME/.composer/vendor/bin"
# after saving and closing the file
source ~/.bash_profile
```

Verify the changes

```powershell
env
```

**Add the following code in your settings.json file**

```php
  "files.trimTrailingWhitespace": true,
  "editor.trimAutoWhitespace": true,
  "editor.useTabStops": true,
  "javascript.format.insertSpaceAfterOpeningAndBeforeClosingNonemptyBrackets": true,
  "javascript.format.insertSpaceAfterOpeningAndBeforeClosingNonemptyParenthesis": true,
  "javascript.format.insertSpaceAfterOpeningAndBeforeClosingNonemptyBraces": false,
  "javascript.preferences.quoteStyle": "single",
  "css.lint.duplicateProperties": "warning",
  "css.lint.ieHack": "warning",
  "css.lint.zeroUnits": "warning",
  "html-css-class-completion.enableFindUsage": true,
  "html-css-class-completion.enableEmmetSupport": true,
  "html-css-class-completion.enableScssFindUsage": true,
  "editor.insertSpaces": false,
  "editor.indentSize": "tabSize",
  "autoalign.minSeparationLeft": 1,
  "autoalign.columnWidth": 1,
  "autoalign.moveableItems": [
    "=>",
    "=",
    ":",
    "+=",
    "-="
  ],
  "[php]": {
    "editor.quickSuggestions": {
      "strings": true
    },
    "editor.defaultFormatter": "valeryanm.vscode-phpsab",
    "editor.formatOnSave": true,
    "editor.formatOnPaste": true,
    "editor.tabSize": 4
  },
  "[html]": {
    "editor.defaultFormatter": "vscode.html-language-features",
    "editor.formatOnSave": false
  },
  // Set Prettier as default formatter
  "editor.defaultFormatter": "esbenp.prettier-vscode",
  // Only format if config file found in project
  "prettier.requireConfig": true,
  // Auto format on save
  "editor.formatOnSave": true,
  "diffEditor.ignoreTrimWhitespace": false,
  // disabled vscode default validation
  "css.validate": false,
  "scss.validate": false,
  "javascript.validate.enable": false,
  // Run stylelint on save
  "editor.codeActionsOnSave": {
    "source.fixAll.stylelint": "explicit"
  },
  "stylelint.validate": [
    "css",
    "postcss",
    "scss"
  ],
  "editor.formatOnPaste": true,
  "editor.formatOnType": true,
  "intelephense.stubs": [
    "apache",
    "bcmath",
    "bz2",
    "calendar",
    "com_dotnet",
    "Core",
    "ctype",
    "curl",
    "date",
    "dba",
    "dom",
    "enchant",
    "exif",
    "FFI",
    "fileinfo",
    "filter",
    "fpm",
    "ftp",
    "gd",
    "gettext",
    "gmp",
    "hash",
    "iconv",
    "imap",
    "intl",
    "json",
    "ldap",
    "libxml",
    "mbstring",
    "meta",
    "mysqli",
    "oci8",
    "odbc",
    "openssl",
    "pcntl",
    "pcre",
    "PDO",
    "pdo_ibm",
    "pdo_mysql",
    "pdo_pgsql",
    "pdo_sqlite",
    "pgsql",
    "Phar",
    "posix",
    "pspell",
    "random",
    "readline",
    "Reflection",
    "session",
    "shmop",
    "SimpleXML",
    "snmp",
    "soap",
    "sockets",
    "sodium",
    "SPL",
    "sqlite3",
    "standard",
    "superglobals",
    "sysvmsg",
    "sysvsem",
    "sysvshm",
    "tidy",
    "tokenizer",
    "xml",
    "xmlreader",
    "xmlrpc",
    "xmlwriter",
    "xsl",
    "Zend OPcache",
    "zip",
    "zlib",
    "wordpress"
  ],
  // PHPCS
  "phpsab.standard": "WordPress",
  "intelephense.environment.includePaths": [
    // point to any folder in your drive and add the ACF Pro plugin inside it
    "C:\\Users\\SAHIL\\Desktop\\intelephense"
  ],
```

Change the directory structure for some of the settings above to match yours.

---

## JavaScript

**All classes and IDs should be lowercase and separated by a dash.**

All the JS files are added inside the /_source/sass/js/plugins_ and /_source/sass/js/custom_ folders and are compiled into a single file located at /_js/plugins.js_

### **Creating a new JS file**

-   **Plugin Code** - Create a new file with the plugin name inside _/the /source/js/plugins_ folder.
-   **Custom Code** - Create a new file with the appropriate-name.js inside _/source/js/custom_ folder.
-   Unlike, SASS partials these file doesn't have to be imported inside the index file. They will automatically get compiled into the single /_js/plugins.js_ file.

---

## CSS

We use SASS for CSS development. All the sass files are created inside the /_source/sass/partials/_ folder and its sub-folders are manually imported inside **/_source/sass/\_style.css_**

Create a new file starting with \_newfile.scss and import it inside **/\*source/sass/\_style.css** to load on front-end\*

### File Structure

Look at the files imported inside **/\*source/sass/\_style.css** and follow the same structure for new files\*

### **Rules**

-   **Never use a PX unit.** Always use the rem unit except for breakpoints and line height. Wrap all px values into the rem-calc() function. Eg. rem-calc(24) without px unit. It will convert the value to rem.
-   If the CSS property have separate mobile and desktop value used fluid($mobileValue, $desktopValue)

---

## HTML - Class/ID Naming Convention

**All classes and IDs should be lowercase and separated by a dash.**

Any design that covers the entire viewport(edge to edge) should use the section tag and should be post-fixed using the section. e.g. \*-section. Generally, it sits outside the container.

```html
<section class="**hero-slider-section**">
	<div class="container"></div>
</section>
```

Any tag inside the section that wraps the container should be called inner-section. It happens in a very rare scenario

```html
<section class="hero-slider-section">
	<div class="inner-section">
		<div class="container"></div>
	</div>
</section>
```

-   Any class/ID **added or targeted** using JavaScript should be prefixed with **"js-"** e.g. **js-active, js-hidden**
-   Avoid ID as much as possible.

Add a comment for every closing tag if it has multiple children for better readability. **Optional**

```html
<section class="hero-slider-section">
	<div class="inner-section">
		<div class="container"></div>
	</div>
</section>
**<!-- .hero-slider-section -->**
```

---

---

## Animation using data attributes

This plugin uses data attributes to control the visibility and animations of HTML elements based on their position in the viewport.

### **Key Data Attributes**

**`data-inview`**

-   This attribute is used to mark elements that should be observed. When the element comes into the viewport, its attribute value is changed to **`true`** and remains **`true`** until the page is reloaded.

**`data-inview-repeat`**

-   Similar to `data-inview`, but the `data-inview` attribute is removed when the element exits the viewport, allowing the in-view action to repeat.

**`data-inview-offset`**

-   Specifies the offset when the element is considered in view. Can be a pixel value (e.g., `50px`) or a percentage (e.g., `10%`).

**`data-inview-threshold`**

-   Defines the proportion of the element that needs to be visible before it is considered in view. Default is `0.05` (5%).

**`data-aos`**

-   Specifies the type of animation to apply to the element. The animation runs when the element's **`data-inview`** attribute is **`true`**.
-   Example: **`data-aos="fade-up"`**

**`data-aos-stagger-item`**

-   Used for staggered animations among child elements within a parent that has the `data-inview` attribute.

### **Usage Details**

1. **Basic Visibility Tracking**:
    - Any element with the **`[data-inview]`** or **`[data-inview-repeat]`** attribute will be monitored.
    - When such an element enters the viewport, its **`data-inview`** attribute will be set to **`true`**.
    - If the element has the **`[data-inview-repeat]`** attribute, the `data-inview` attribute will be removed when the element exits the viewport, allowing the animation or action to repeat upon re-entering the viewport.
2. **Animation on Scroll**:
    - Elements with the **`[data-aos]`** attribute will wait for their corresponding **`[data-inview]`** attribute to become **`true`**.
    - The value of **`[data-aos]`** defines the type of transition. For example, **`data-aos="fade-up"`** triggers a fade-up animation.
3. **Staggered Animations**:
    - To create staggered animations, add **`[data-inview]`** to the parent element and use **`[data-aos]`** and **`[data-aos-stagger-item]`** attributes for its direct children.
    - This setup allows for coordinated, staggered animations among the child elements.

### **CSS Custom Properties**

You can control various transition properties using the following custom CSS properties. These properties can be set on the parent element or globally:

-   **`-aos-duration`**: Defines the duration of the transition. Default: **`1000ms`**
-   **`-aos-delay`**: Sets the delay before the transition starts. Note: This does not apply to staggered items. Default: **`0ms`**
-   **`-aos-stagger-interval`**: Interval between the start of animations for staggered items. This should be set on the parent element of staggered items. Default: **`100ms`**
-   **`-aos-distance`**: The distance an element moves during the transition. Default: **`40px`**

All timing values are specified in milliseconds (**`ms`**).

---

## Toggle state/class using data attributes

This plugin allows you to add interactive features to your elements by toggling the `js-active` class based on click and hover events. It utilizes data attributes to define toggle behaviors and to link elements together.

### Key Data Attributes

-   **`data-toggle-click`**: Specifies the elements that should toggle the `js-active` class when clicked. If this attribute is set, the element will toggle its active state upon a click event.
-   **`data-toggle-group`**: Groups elements together, ensuring that only one element in the group has the `js-active` class at a time. When an element with this attribute is clicked, it will remove the `js-active` class from other elements in the same group.
-   **`data-toggle-link`**: Links elements together, ensuring that related elements toggle the `js-active` class in unison. When the element with this attribute is toggled, all linked elements will also toggle their active state.
-   **`data-toggle-hover`**: Specifies the elements that should toggle the `js-active` class when hovered over. Linked elements defined with `data-toggle-link` will also be toggled.

### Usage Details

1. **Click Interaction**:

    - Elements with the `data-toggle-click` attribute will toggle the `js-active` class when clicked.
    - If the element belongs to a group (`data-toggle-group`), clicking it will remove the `js-active` class from other elements in the same group.
    - Example:

        ```html
        <div data-toggle-click="example" data-toggle-group="group1"></div>
        <div data-toggle-click="example" data-toggle-group="group1"></div>
        ```

2. **Hover Interaction**:

    - Elements with the `data-toggle-hover` attribute will toggle the `js-active` class when hovered over.
    - Linked elements defined with `data-toggle-link` will also be toggled.
    - Example:

        ```html
        <div data-toggle-hover="example"></div>
        <div data-toggle-link="example"></div>
        ```

3. **Linked Elements**:

    - Elements with the `data-toggle-link` attribute will toggle the `js-active` class when their corresponding `data-toggle-click` or `data-toggle-hover` element is interacted with.
    - Example:

        ```html
        <div data-toggle-click="example"></div>
        <div data-toggle-link="example"></div>
        ```
