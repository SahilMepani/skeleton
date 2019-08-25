<?php /* Template Name: Documentation */ ?>

<?php get_header(); ?>

<div class="container">

  <div class="row py-5">

    <div class="col-sm-4 sidebar-col">
      <div class="sidebar-inner-block">

        <div class="search-block">

        </div> <!-- .search-block -->

        <ul class="list-unstyled">
          <li><a href="#">Dev Handoff</a></li>
          <li><a href="#wp-installation">WP Installation</a></li>
          <ul>
            <li><a href="#local">Local</a></li>
            <li><a href="#development">Development</a></li>
            <li><a href="#production">Production</a></li>
          </ul>
          <li><a href="#theme-installation">Theme Installation</a></li>
          <li><a href="#css-styleguide">CSS/SASS Styleguide</a></li>
          <ul>
            <li><a href="#terminology">Terminology</a></li>
            <li><a href="#css">CSS</a></li>
            <li><a href="#sass">SASS</a></li>
          </ul>
          <li><a href="#">Pre Launch</a></li>
          <li><a href="#">Post Launch</a></li>
        </ul> <!-- .list-unstyled -->

      </div> <!-- .sidebar-inner-block -->
    </div> <!-- .col-sm-4 -->

    <div class="col-sm-8 content-col">

      <h3 id="post-launch">Dev Handoff</h3>

      <ul>
        <li>Upload the design to avocode</li>
        <li>Ready the assets link</li>
        <li>Install the browser extension "Loom" to record handoff</li>
        <li>Designer please record the handoff using loom and forward the video link to developer</li>
        <li>You may add notes to avocode during the handoff</li>
      </ul>

      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="wp-installation">WP Installation</h3>

      <p>Work with 3 different WP installations. Local, Development and Production. When the site is coded and ready, migrate the local to development for internal QC and client reivew. If there are any bugs, fix them locally and push them to development. If there are any changes to database/content. First pull the database from development to local, make the changes locally and push back the database to development. After QC is completed, push the development to production.</p>

      <h5 id="local">Local</h5>
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
            <li>Create a user "threesixtyeight" with password "$$3hree6ixty8ight$$" and email "dev@threesixtyeight.com"</li>
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
            <li><a href="https://drive.google.com/open?id=1mnHwgKTWIWu6wZTWzajsrVnKXKfnv9R_" target="_blank">All plugins download link</a></li>
            <li>Admin Menu Editor - <a href="https://wordpress.org/plugins/admin-menu-editor/" target="_blank">Plugin page</a></li>
            <li>Advanced Custom Field Pro - <a href="https://drive.google.com/open?id=1ffGYPATxigIHQcN_eeHmrtkYrk1zkrvc" target="_blank">Download link</a> <br /><small><code>b3JkZXJfaWQ9MzQxNzV8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE0LTA3LTA5IDIyOjMyOjAw</code></small></li>
            <li>All in one migration - <a href="https://drive.google.com/open?id=11qcKb-10IbI3UVKtpV76-x_J6IhuhZOc" target="_blank">Download link</a> <br /><small><code>1d090987-fae0-4172-a8cd-cc7689dfe3d5</code></small></li>
            <li>Classic Editor - <a href="https://wordpress.org/plugins/classic-editor/" target="_blank">Plugin page</a></li>
            <li>Duplicate Post - <a href="https://wordpress.org/plugins/duplicate-post/" target="_blank">Plugin page</a></li>
            <li>Enhanced Media Library - <a href="https://wordpress.org/plugins/enhanced-media-library/" target="_blank">Plugin page</a></li>
            <li>Gravity Forms - <a href="https://drive.google.com/open?id=1KaBtpGtUL7mZam_EPt415UW0XpIMIMPJ" target="_blank">Download link</a> <br /> <small><code>c20f6083662ea51a3d85ddddab0e6d36</code></small></li>
            <li>Redirection - <a href="https://wordpress.org/plugins/redirection/" target="_blank">Plugin page</a></li>
            <li>Regenerate Thumbnails - <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Plugin page</a></li>
            <li>SearchWP - <a href="https://drive.google.com/open?id=1AAayYivM5aqzhrQTC_4dle7IjdjiLEC3" target="_blank">Download link</a> <br /> <small><code>8d1c00c38a2e1a0919a5d5d3392b608e</code></small></li>
            <li>Yoast SEO - <a href="https://wordpress.org/plugins/wordpress-seo/" target="_blank">Plugin page</a></li>
            <li>WP Migrate DB Pro - <a href="https://drive.google.com/open?id=1YKMpXI16Ilc93EWZGZvCtaNShHfXNLbZ" target="_blank">Download link</a> <br /> <small><code>a5684f4b-bd85-453e-8fb2-3feb32d64b7c</code></small></li>
          </ul>
          <p>Plugins downloaded directly needs to be updated once installed</p>
      </ol>

      <h5 id="development">Development</h5>

      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque unde incidunt eum, molestias, voluptatem eligendi numquam itaque aut deserunt, temporibus et debitis! Blanditiis reiciendis nesciunt at commodi voluptate recusandae eum.</p>

      <h5 id="production">Production</h5>

      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque unde incidunt eum, molestias, voluptatem eligendi numquam itaque aut deserunt, temporibus et debitis! Blanditiis reiciendis nesciunt at commodi voluptate recusandae eum.</p>

      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="theme-installation">Theme Installation</h3>
      <ol>
        <li>Switch to themes directory <br />
          <code>cd /path/to/your/repo</code>
        </li>
        <li>Clone the skeleton theme
          <div class="mt-1">
            <b>SSH</b>: <br /> <code class="p-1 d-block">git clone git@bitbucket.org:threesixtyeight/skeleton-reloaded.git</code>
          </div> <!-- .mt-1 -->
          <div class="mt-1">
            <b>HTTP</b>: <br /> <code class="p-1 d-block">git clone https://sahilmepani@bitbucket.org/threesixtyeight/skeleton-reloaded.git</code>
          </div> <!-- .mt-1 -->
        </li>
        <li>Rename the theme folder to match the project name <small>(ask manager)</small></li>
        <li>Update theme info in sass/style.scss file. Theme name should match the project name</li>
        <li>Create a screenshot.png (1200 x 900) file in the theme directory <small>(ask designer)</small></li>
        <li>Go to Appearance => Themes and activate the theme</li>
        <li>Create favicon.png and favicon.ico files <small>(ask designer)</small></li>
        <li>Make the Initial Commit</li>
        <li class="text-highlight">Create all the pages from sitemap with heirarchy and required URL structure <small>(ask manager)</small></li>
      </ol>

      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="git">Git</h3>

      <ol>
        <li>Create a new repo on bitbucket matching the project name</li>
        <li>Get your local Git repository on Bitbucket</li>
        <ul>
          <li>Switch to your repository's directory <br />
            <small><code>cd /path/to/your/repo</code></small>
          </li>
          <li>Connect your existing repository to Bitbucket <br />
            <small>
              <code>git remote add origin git@bitbucket.org:sahilmepani/fsfs.git</code>
              <code>git push -u origin master</code>
            </small>
          </li>
        </ul>
      </ol>

      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


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