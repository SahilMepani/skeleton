<?php /* Template Name: Documentation */ ?>

<?php get_header(); ?>

<div class="container">

  <div class="row py-5">

    <div class="col-sm-4 sidebar-col">
      <div class="sidebar-inner-block">

        <div class="search-block">

        </div> <!-- .search-block -->

        <ul class="list-unstyled">
          <li><a href="#wp-installation">WP Installation</a></li>
          <li><a href="#theme-installation">Theme Installation</a></li>
          <li><a href="#css-styleguide">CSS Styleguide</a></li>
        </ul> <!-- .list-unstyled -->

      </div> <!-- .sidebar-inner-block -->
    </div> <!-- .col-sm-4 -->

    <div class="col-sm-8 content-col">
      <h3 id="wp-installation">WP Installation</h3>
      <ol>
        <li>Edit wp-config.php file in root directory</li>
        <ul>
          <li>Set <b>$table_prefix</b> to <b>tse_</b></li>
          <li>Set <b>WP_DEBUG</b> variable to <b>true</b></li>
          <li>Add <b>define( 'WP_POST_REVISIONS', 3 );</b></li>
        </ul>
        <li>Create a user "<b>threesixtyeight</b>" with password "<b>$$3hree6ixty8ight$$</b>" and email "<b>dev@threesixtyeight.com</b>"</li>
        <li>Create pages "<b>Home</b>" and "<b>Blog</b>"</li>
        <li>Go to <b>Settings => General</b> and update "<b>Site Title</b>" and "<b>Tagline</b>" <small>(ask manager)</small></li>
        <li>Go to <b>Settings => Reading</b></li>
        <ul>
          <li>Select "<b>A static page</b>" and select page <b>home for "Homepage"</b> and page <b>blog for "Posts page"</b></li>
          <li>Check "<b>Discourage search engine...</b>"</li>
          <li>Set "<b>Blog pages show at most</b>" to "<b>5</b>"</li>
        </ul>
        <li>Go to <b>Settings => Permalinks</b> and select "<b>Custom structure</b>" and set its value to "<b>/%postname%/</b>" without quotes</li>
        <li>Go to <b>Settings => Discussions</b></li>
        <ul>
          <li>If comments not allowed, Uncheck "<b>Allow people to post comments on new articles</b>"</li>
          <li>If comments not allowed, Uncheck "<b>Show Avatars</b>"</li>
        </ul>
        <li>Install and activate the following plugins:</li>
      </ol>

      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="theme-installation">Theme Installation</h3>
      <ol>
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
        <li>Create all the pages from sitemap with heirarchy and required URL structure <small>(ask manager)</small></li>
      </ol>

      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="pre-launch">CSS/SASS Styleguide</h3>
      <h4 class="mb-4">Terminology</h4>

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

      <h4 id="css-styleguide" class="mb-4">CSS</h4>

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

      <h4 class="mb-4">SASS</h4>

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


      <hr />
      <div class="mb-5"></div> <!-- .mb-5 -->


      <h3 id="pre-launch">JS Styleguide</h3>
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