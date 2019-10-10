<?php /* Template Name: Documentation */ ?>

<?php get_header(); ?>

<div class="container">

  <div class="row py-5">

    <div class="col-sm-4 sidebar-col">
      <div class="sidebar-inner-block">

        <div class="search-block">

        </div> <!-- .search-block -->

        <ul class="list-unstyled">
          <li><a href="#">1. Dev Handoff</a></li>
          <li><a href="#wp-installation">2. WP Installation</a></li>
          <ul>
            <li><a href="#local">2.1 Local</a></li>
            <li><a href="#development">2.2 Development</a></li>
            <li><a href="#production">2.3 Production</a></li>
          </ul>
          <li><a href="#skeleton-setup">3. Skeleton Setup</a></li>
          <ul>
            <li><a href="#skeleton-installation">3.1 Installation</a></li>
            <li><a href="#skeleton-repo">3.2 Creating Repo</a></li>
          </ul>
          <li><a href="#skeleton-sass">3. Skeleton SASS</a></li>
          <ul>
            <li><a href="#skeleton-installation">3.1 Installation</a></li>
            <li><a href="#skeleton-repo">3.2 Creating Repo</a></li>
          </ul>
          <li><a href="#css-styleguide">4. CSS/SASS Styleguide</a></li>
          <ul>
            <li><a href="#terminology">4.1 Terminology</a></li>
            <li><a href="#css">4.2 CSS</a></li>
            <li><a href="#sass">4.3 SASS</a></li>
          </ul>
          <li><a href="#">Pre Launch</a></li>
          <li><a href="#">Post Launch</a></li>
          <li><a href="#">Theme Usage</a></li>
        </ul> <!-- .list-unstyled -->

      </div> <!-- .sidebar-inner-block -->
    </div> <!-- .col-sm-4 -->

    <div class="col-sm-8 content-col">

      <h3 id="post-launch">1. Dev Handoff</h3>

      <ul>
        <li>Upload the design to avocode before the handoff</li>
        <li>Install the browser extension "Loom" to record handoff</li>
        <li>Designer should record the handoff and forward the video link to developer <small>(sometimes due to connectivity issue, the conversation doesn't go through. But it is vital to have the designer's explanation which can only be recorded if they do the recording)</small></li>
        <li>You may add notes to avocode during the handoff</li>
        <li>Organize the assets into folders and forward the download/GDrive link</li>
        <ul>
          <li>Trim the whitespace around all the images. If required, it can be created using CSS</li>
          <li>Icons must use fills. <a href="https://icomoon.io/">Icomoon app</a> ignores strokes. <a href="https://icomoon.io/docs.html">Learn here</a> on how to convert strokes and text to fills</li>
        </ul>
        <li>Styleguide should minimum include the following for both a mobile and desktop</li>
        <ul>
          <li>Typography: <br /> Headings(h1 to h6), paragraph, blockquote, links and any other custom font styles</li>
          <li>Form Inputs</li>
          <li>Buttons</li>
          <li>Components with hover state</li>
        </ul>
      </ul>

      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="wp-installation">2. WP Installation</h3>

      <p>Work with 3 different WP installations. Local, Development and Production.</p>

      <h5 id="local">2.1 Local WP (development branch)</h5>
      <ol>
        <li>Download latest WordPress - <a href="https://wordpress.org/latest.zip">Download link</a></li>
        <li>Edit wp-config.php file in root directory</li>
        <ul>
          <li>Set $table_prefix to tse_</li>
          <li>Set WP_DEBUG variable to true</li>
          <li>Add define( 'WP_POST_REVISIONS', 3 );</li>
        </ul>
        <li>Start WordPress installation</li>
          <ul>
            <li>Update WP database details</li>
            <li>Update "Site Title" <small>(ask manager)</small></li>
            <li>Create a TSE user</li>
            <li>Uncheck "Allow search engine..."</li>
          </ul>
        <li>Create pages "Home" and "Blog"</li>
        <li>Go to Settings => General and update "Tagline" <small>(ask manager)</small></li>
        <li>Go to Settings => Reading</li>
        <ul>
          <li>Select "A static page" and select page home for "Homepage" and page blog for "Posts page"</li>
          <li>Set "Blog pages show at most" to "5"</li>
        </ul>
        <li>Go to Settings => Permalinks and select "Custom structure" and set its value to "/%postname%/" without quotes</li>
        <li>Go to Settings => Discussions</li>
        <ul>
          <li>If comments not allowed, Uncheck "Allow people to post comments on new articles"</li>
          <li>If comments not allowed, Uncheck "Show Avatars"</li>
        </ul>
        <li>Install and activate the following plugins with licence code:</li>
          <ul>
            <li><a href="https://drive.google.com/open?id=1nzQAAZNAvg_SJbrTqWkuqUrWR9auybaB" target="_blank">All plugins download link</a></li>
            <li>Admin Menu Editor - <a href="https://wordpress.org/plugins/admin-menu-editor/" target="_blank">Plugin page</a></li>
            <li>Advanced Custom Field Pro - <a href="https://drive.google.com/open?id=1ffGYPATxigIHQcN_eeHmrtkYrk1zkrvc" target="_blank">Download link</a> <br /><small><code>b3JkZXJfaWQ9MzQxNzV8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE0LTA3LTA5IDIyOjMyOjAw</code></small></li>
            <li>All in one migration - <a href="https://drive.google.com/open?id=1MuoA5cSLcGYhIbRMxKDtysTbUM63swVa" target="_blank">Download link</a> <br /><small><code>1d090987-fae0-4172-a8cd-cc7689dfe3d5</code></small></li>
            <li>All in one migration Unlimited Editon - <a href="https://drive.google.com/open?id=1yK2yGZLB38zYc1OGC1oQ3Y7kHBsBMi4H" target="_blank">Download link</a> <br /><small><code>1d090987-fae0-4172-a8cd-cc7689dfe3d5</code></small></li>
            <li>Classic Editor - <a href="https://wordpress.org/plugins/classic-editor/" target="_blank">Plugin page</a></li>
            <li>Duplicate Post - <a href="https://wordpress.org/plugins/duplicate-post/" target="_blank">Plugin page</a></li>
            <li>Enhanced Media Library - <a href="https://wordpress.org/plugins/enhanced-media-library/" target="_blank">Plugin page</a></li>
            <li>Gravity Forms - <a href="https://drive.google.com/open?id=1KaBtpGtUL7mZam_EPt415UW0XpIMIMPJ" target="_blank">Download link</a> <br /> <small><code>c20f6083662ea51a3d85ddddab0e6d36</code></small></li>
            <li>Redirection - <a href="https://wordpress.org/plugins/redirection/" target="_blank">Plugin page</a></li>
            <li>Regenerate Thumbnails - <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Plugin page</a></li>
            <li>SearchWP - <a href="https://drive.google.com/open?id=1AAayYivM5aqzhrQTC_4dle7IjdjiLEC3" target="_blank">Download link</a> <br /> <small><code>8d1c00c38a2e1a0919a5d5d3392b608e</code></small></li>
            <li>Yoast SEO - <a href="https://wordpress.org/plugins/wordpress-seo/" target="_blank">Plugin page</a></li>
            <li id="wp-migrate-db-pro">WP Migrate DB Pro - <a href="https://drive.google.com/open?id=1bsSQUqjceACc4IIPeKSTwItIuRQxJ6Id" target="_blank">Download link</a> <br /> <small><code>a5684f4b-bd85-453e-8fb2-3feb32d64b7c</code></small></li>
            <li id="wp-migrate-db-pro">WP Migrate DB Pro Media Files - <a href="https://drive.google.com/open?id=1IYPn1PngeL6aSvzGquDlGZS9liYUj1o9" target="_blank">Download link</a> <br /> <small><code>a5684f4b-bd85-453e-8fb2-3feb32d64b7c</code></small></li>
            <li id="wp-migrate-db-pro">WP Migrate DB Pro Theme and Plugin files - <a href="https://drive.google.com/open?id=1ZWi7OkPZ5s-7JkxkVQ4RrlK0ADLjfQ-E" target="_blank">Download link</a> <br /> <small><code>a5684f4b-bd85-453e-8fb2-3feb32d64b7c</code></small></li>
          </ul>
          <p>Plugins downloaded directly needs to be updated once installed</p>
      </ol>

      <h5 id="development">2.2 Development WP (development branch)</h5>

      <p>Once the site is coded and ready, migrate the local WP to development WP for internal QC and client review. If there are any bugs, fix them on local WP and push them to development WP. If there are any changes to content/media. First pull the database from development WP to local WP, make the changes on local WP and push back the database to development WP. It is vital that the local WP and development WP are always in sync</p>

      <p><a href="#wp-migrate-db-pro">WP Migrate DB Pro</a> plugin is used to push and pull database and <a href="https://deploybot.com" target="_blank">DeployBot</a> for uploading theme/repo files</p>

      <h5 id="production">2.3 Production WP (master branch)</h5>

      <p>After QC is completed, push the development WP to production WP. Also, merge the development branch with master branch <br /><code>git checkout master</code><br /><code>git merge development</code></p>

      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="skeleton-setup">3. Skeleton Setup</h3>

      <h5 id="skeleton-installation">3.1 Installation</h5>

      <ol>
        <li>Switch to themes directory <br />
          <code>cd /path/to/your/wp-content/themes</code>
        </li>
        <li>Download the skeleton theme and not clone
          <div class="mt-1">
            <code>https://bitbucket.org/threesixtyeight/skeleton-reloaded/src/master/</code>
          </div>
        </li>
        <li>Rename the theme folder to match the project name <small>(ask manager)</small></li>
        <li>Create a screenshot.png (1200 x 900) file in the theme directory <small>(ask designer)</small></li>
        <li>Create favicon.png and favicon.ico files <small>(ask designer)</small></li>
        <li>Run <code>node -v</code> anywhere to check if you have Node.js installed in your system. If not, download from <a href="https://nodejs.org/en/" target="_blank">Node.js</a> and install </li>
        <li>Install grunt <br /> <code>npm install grunt</code></li>
        <li>Go to theme source folder <br /> <code>cd /path/to/your/wp-content/themes/skeleton/source</code></li>
        <li>Run the following command to install all the necessary packages to run grunt tasks <br /> <code>npm install</code></li>
        <li>
          Run the following command for grunt to compile all the scss/js files <br />
          <div class="mb-1">
            <code>cd /path/to/your/wp-content/themes/skeleton/source</code> <br />
            <code>grunt</code>
          </div>
          <p>All the scss files are created inside the source/sass/partials/ folder and its sub-folders. All the js files are divided into two folders source/js/plugins and source/js/custom. Grunt will compile all the source/sass/partials/.scss files into a single file style.css and source/js/plugins/.js files into js/plugins.js file and source/js/custom/.js files into js/custom.js
        </li>
        <li>Update theme info in sass/style.scss file. Theme name should match the project name</li>
        <li>Make the Initial Commit</li>
        <li>Go to Appearance => Themes and activate the theme</li>
        <li class="text-highlight">Create all the pages from sitemap with heirarchy and required URL structure <small>(ask manager)</small></li>
      </ol>

      <h5 id="skeleton-repo">3.2 Creating Repo</h5>

      <ol>
        <li>Create a new repo on bitbucket matching the project name</li>
        <li>Get your local Git repository on Bitbucket</li>
        <ul>
          <li>Switch to your repository's directory <br />
            <code>cd /path/to/your/repo</code>
          </li>
          <li>Connect your existing repository to Bitbucket <br />
              <code>git remote add origin git@bitbucket.org:threesixtyeight/your-repo-name.git</code>
              <code>git push -u origin master</code>
            </small>
          </li>
        </ul>
      </ol>

      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="skeleton-sass">Skeleton SASS</h3>

      <p>All sass files are stored inside source/sass/partials folder and its subfolders except the style.scss file</p>

      <ul>
        <li><b>styles.scss</b> - contains the theme information and imports all the partials which needs to be compiled</li>
        <li><b>partials/variables.scss</b> - setup the variables as per the styleguide and designs. Includes colors, breakpoints, sizes, spacing and many other utility classes variables too.</li>
        <li><b>partials/<a href="https://necolas.github.io/normalize.css/" target="_blank">normalize.scss</a></b> - makes browsers render all elements more consistently and in line with modern standards.</li>
        <li><b>partials/base-selectors.scss</b> - contains all the basic html selectors. Edit the headings styles as per the styleguide</li>
        <li><b>partials/base-styles.scss</b> - contains helpers classes which needs to compiled early so they can overridden if required</li>
        <li><b>partials/<a href="https://getbootstrap.com/docs/4.3/layout/grid/" target="_blank">grid.scss</a></b> - contains all the grid system classes from Bootstrap</li>
        <li><b>partials/ie.scss</b> - contains ie specific styles</li>
        <li><b>partials/print.scss</b> - contains print styles</li>
        <li><b>partials/shame.scss</b> - contains last minute styles which needs to be moved to specific scss file</li>
        <li><b>partials/mixins/</b>- contains mixin files which are used to generate grid, breakpoints and other classes. Please go through their code to understand their function</li>
      </ul>

      <h5 id="skeleton-usage">3.3 Usage</h5>

      <ol>
        <li>Update variables.scss</li>
        <li>Update headings styles in base-selectors.scss file</li>
      </ol>

      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="skeleton-setup">3. Skeleton Setup</h3>

      <h5 id="skeleton-installation">3.1 Installation</h5>


      <h3 id="css-styleguide">CSS/SASS Styleguide</h3>
      <h4 id="terminology" class="mb-4">Terminology</h4>

      <h5>Rule Declaration</h5>
      <p>A "rule declaration" is the name given to a selector (or a group of selectors) with an accompanying group of properties. Here's an example:</p>
<code class="d-block p-1">
<pre>
.listing {
  font-size: 18px;
  line-height: 1.2;
}
</pre>
</code>

      <h5>Selectors</h5>
      <p>In a rule declaration, “selectors” are the bits that determine which elements in the DOM tree will be styled by the defined properties. Selectors can match HTML elements, as well as an element's class, ID, or any of its attributes. Here are some examples of selectors:</p>
<code class="d-block p-1">
<pre>
.my-element-class {
  /* ... */
}

[aria-hidden] {
  /* ... */
}
</pre>
</code>

      <h5>Properties</h5>
      <p>Finally, properties are what give the selected elements of a rule declaration their style. Properties are key-value pairs, and a rule declaration can contain one or more property declarations. Property declarations look like this:</p>
<code class="d-block p-1">
<pre>
/* some selector */ {
  background: #f1f1f1;
  color: #333;
}
</pre>
</code>

      <h4 id="css" class="mb-4">CSS</h4>

      <h5>Formatting</h5>
      <ul>
        <li>Use soft tabs (2 spaces) for indentation.</li>
        <li>Prefer dashes over camelCasing in class names.</li>
        <li>Do not use ID selectors.</li>
        <li>When using multiple selectors in a rule declaration, give each selector its own line.</li>
        <li>Put a space before the opening brace { in rule declarations.</li>
        <li>In properties, put a space after, but not before, the : character.</li>
        <li>Put closing braces } of rule declarations on a new line.</li>
        <li>Put blank lines between rule declarations.</li>
      </ul>

      <p class="mb-1"><b>Bad</b></p>
<code class="d-block p-1 mb-2">
<pre>
.avatar{
    border-radius:50%;
    border:2px solid white; }
.no, .nope, .not_good {
    // ...
}
#lol-no {
  // ...
}
</pre>
</code>

      <p class="mb-1"><b>Good</b></p>
<code class="d-block p-1">
<pre>
.avatar {
  border-radius: 50%;
  border: 2px solid white;
}

.one,
.selector,
.per-line {
  // ...
}
</pre>
</code>

      <h5>Comments</h5>
      <ul>
        <li>Prefer line comments (// in Sass-land) to block comments.</li>
        <li>Prefer comments on their own line. Avoid end-of-line comments.</li>
        <li>Write detailed comments for code that isn't self-documenting:</li>
        <ul>
          <li>Uses of z-index</li>
          <li>Compatibility or browser-specific hacks</li>
        </ul>
      </ul>

      <h5>ID selectors</h5>
      <p>While it is possible to select elements by ID in CSS, it should generally be considered an anti-pattern. ID selectors introduce an unnecessarily high level of specificity to your rule declarations, and they are not reusable.</p>

      <p>For more on this subject, read <a href="http://csswizardry.com/2014/07/hacks-for-dealing-with-specificity/">CSS Wizardry's article</a> on dealing with specificity.</p>

      <h5>JavaScript hooks</h5>
      <p>Avoid binding to the same class in both your CSS and JavaScript. Conflating the two often leads to, at a minimum, time wasted during refactoring when a developer must cross-reference each class they are changing, and at its worst, developers being afraid to make changes for fear of breaking functionality.</p>

      <p>We recommend creating JavaScript-specific classes to bind to, prefixed with .js-:</p>

      <h5>Border</h5>

      <p>Use <code>0</code> instead of <code>none</code> to specify that a style has no border.</p>
      <p class="mb-1"><b>Bad</b></p>
<code class="d-block p-1 mb-2">
<pre>
.foo {
  border: none;
}
</pre>
</code>

      <p class="mb-1"><b>Good</b></p>
<code class="d-block p-1">
<pre>
.foo {
  border: 0;
}
</pre>
</code>

      <h4 id="sass" class="mb-4">SASS</h4>

      <h5>Syntax</h5>

      <p>Use the <code>.scss</code> syntax, never the original .sass syntax</p>

      <h5>Variables</h5>
      <p>Prefer dash-cased variable names (e.g. <code>$my-variable</code>) over camelCased or snake_cased variable names. It is acceptable to prefix variable names that are intended to be used only within the same file with an underscore (e.g. <code>$_my-variable</code>).</p>

      <h5>Mixins</h5>
      <p>Mixins should be used to DRY up your code, add clarity, or abstract complexity--in much the same way as well-named functions. Mixins that accept no arguments can be useful for this, but note that if you are not compressing your payload (e.g. gzip), this may contribute to unnecessary code duplication in the resulting styles.</p>

      <h5>Extend directive</h5>
      <p><code>@extend</code> should be avoided because it has unintuitive and potentially dangerous behavior, especially when used with nested selectors. Even extending top-level placeholder selectors can cause problems if the order of selectors ends up changing later (e.g. if they are in other files and the order the files are loaded shifts). Gzipping should handle most of the savings you would have gained by using <code>@extend</code>, and you can DRY up your stylesheets nicely with mixins.</p>

      <h5>Nested selectors</h5>

      <p><b>Do not nest selectors more than three levels deep!</b></p>

<code class="d-block p-1 mb-4">
<pre>
.page-container {
  .content {
    .profile {
      // STOP!
    }
  }
}
</pre>
</code>

      <p>When selectors become this long, you're likely writing CSS that is:</p>

      <ul>
        <li>Strongly coupled to the HTML (fragile) —OR—</li>
        <li>Overly specific (powerful) —OR—</li>
        <li>Not reusable</li>
      </ul>

      <p>Again: <b>never nest ID selectors!</b></p>

      <p>If you must use an ID selector in the first place (and you should really try not to), they should never be nested. If you find yourself doing this, you need to revisit your markup, or figure out why such strong specificity is needed. If you are writing well formed HTML and CSS, you should never <b>need</b> to do this.</p>

      <p>Nested selectors, if necessary, go last, and nothing goes after them. Add whitespace between your rule declarations and nested selectors, as well as between adjacent nested selectors. Apply the same guidelines as above to your nested selectors.</p>
<p class="mb-1"><b>Bad</b></p>
<code class="d-block p-1 mb-2">
<pre>
.btn {
  background: green;
  .icon {
    margin-right: 10px;
  }
  font-weight: bold;
  @include transition(background 0.5s ease);
}
</pre>
</code>
<p class="mb-1"><b>Good</b></p>
<code class="d-block p-1 mb-4">
<pre>
.btn {
  background: green;
  font-weight: bold;
  @include transition(background 0.5s ease);

  .icon {
    margin-right: 10px;
  }
}
</pre>
</code>

<h4 id="sass" class="mb-4">Custom Mixins</h4>

<div class="alert alert-info p-1">
  <p>The rem unit, which stands for "root em" is relative to the font-size of html element</p>
</div> <!-- .alert alert-info -->

<h5>rem-calc() function</h5>
<p>Convert px units to rem. Divide the px value by $root-font-size. It is very important to wrap all the px values inside the rem-calc function for the scaling to work</p>
<h6 class="mt-0">Usage</h6>
<code class="d-block p-1 mb-4">
<pre>
h6 {
  font-size: rem-calc( 20px ); // 20px/$root-font-size(10px) which outputs 2rem
}
</pre>
</code>


<h5>fluid()</h5>

<p>Scale any CSS property with px units values between 2 given breakpoints. Mostly it is used for font-size property</p>

<h6 class="mt-0">Mixins</h6>
<code class="overflow-auto d-block p-1 mb-4">
<pre>
@mixin fluid($properties, $min-screen, $max-screen, $min-value, $max-value, $default: true, $max-breakpoint: true) {
  & {

    @if ( $default ) {
      @each $property in $properties {
        #{$property}: $min-value;
      }
    }

    @media screen and (min-width: $min-screen) {
      @each $property in $properties {
        #{$property}: calc-interpolation($min-screen, $min-value, $max-screen, $max-value);
      }
    }

    @if ( $max-breakpoint ) {
      @media screen and (min-width: $max-screen) {
        @each $property in $properties {
          #{$property}: rem-calc( $max-value );
        }
      }
    }
  }
}
</pre>
</code>

<h6 class="mt-0">Usage</h6>
<code class="overflow-auto d-block p-1 mb-4">
<pre>
h6 {
  @include fluid(font-size, 375px, 1920px, 18px, 36px);
  // variables can also be used for any of the parameters
  // $max-screen cannot be larger than the $scaling variable set in variables.scss
  // sets font-size to $min-value(18px) as a default for anything smaller than $min-screen
  // px units are converted to rem units, similar to rem-calc()
  // start scaling font-size from $min-value(18px) on a device with width of $min-screen(375px) to $max-value(36px) on a device with width of $max-screeen(1920px)
  // scaling happens propotionately between the screen sizes. For eg. If $min-screen is 100px and $max-screen is 200px and the $min-value is 10px and $max-value is 20px. For every 1px change in screen size the font-size will be increase by 0.1px and for every 10px change in screen size the font-size be increase by 1px
  // above $max-screen(1920px) the font-size will scale depending on the font-size set on html element
}
</pre>
</code>

      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="js-styleguide">JS Styleguide</h3>
      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="pre-launch">Pre Launch</h3>
      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="post-launch">Post Launch</h3>
      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->

    </div> <!-- .col-sm-8 content-col -->

  </div> <!-- .row -->

</div> <!-- .container -->

<?php get_footer(); ?>