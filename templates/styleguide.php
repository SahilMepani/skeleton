<?php /* Template Name: Styleguide */ ?>

<?php get_header(); ?>

<div class="container py-4">

<div class="grid-section">
  <h3 class="mb-4">Bootstrap Grid</h3>

  <p>Bootstrap's grid system allows up to 12 columns across the page. If you do not want to use all 12 column individually, you can group the columns together to create wider columns:</p>

  <p class="mb-1">All columns should be wrapped inside a row</p>

  <code class="d-block p-1 mb-3">
  <pre>
  &lt;div class="row"&gt;
    &lt;div class="col-8"&gt;Dummy Text&lt;/div&gt;
    &lt;div class="col-4"&gt;Dummy Text&lt;/div&gt;
  &lt;/div&gt;
  </pre>
  </code>

  <p>Bootstrap's grid system is responsive, and the columns will re-arrange depending on the screen size: On a big screen it might look better with the content organized in three columns, but on a small screen it would be better if the content items were stacked on top of each other.</p>
  <p>Remember that grid columns should add up to twelve for a row. More than that, columns will stack no matter the viewport.</p>

  <code class="d-inline-block p-1 mb-1">&lt;div class="col-1"&gt;</code>
  <div class="row text-center mb-3">
    <div class="col-1">
      <div class="bg-grey p-2">Hi</div>
    </div>
  </div> <!-- .row -->

  <code class="d-inline-block p-1 mb-1">&lt;div class="col-2"&gt;</code>
  <div class="row text-center mb-3">
    <div class="col-2"><div class="bg-grey p-2">Hi</div></div>
  </div> <!-- .row -->

  <code class="d-inline-block p-1 mb-1">&lt;div class="col-3"&gt;</code>
  <div class="row text-center mb-3">
    <div class="col-3"><div class="bg-grey p-2">Hi</div></div>
  </div> <!-- .row -->

  <code class="d-inline-block p-1 mb-1">&lt;div class="col-4"&gt;</code>
  <div class="row text-center mb-3">
    <div class="col-4"><div class="bg-grey p-2">Hi</div></div>
  </div> <!-- .row -->

  <code class="d-inline-block p-1 mb-1">&lt;div class="col-5"&gt;</code>
  <div class="row text-center mb-3">
    <div class="col-5"><div class="bg-grey p-2">Hi</div></div>
  </div> <!-- .row -->

  <code class="d-inline-block p-1 mb-1">&lt;div class="col-6"&gt;</code>
  <div class="row text-center mb-3">
    <div class="col-6"><div class="bg-grey p-2">Hi</div></div>
  </div> <!-- .row -->

  <p>It can go till <code>&lt;div class="col-12"&gt;</code></p>
</div> <!-- .grid-section -->

<hr class="mb-9" />

<div class="typography-section">

  <h3 class="mb-4">Typography</h3>

  <div class="row">

    <div class="col-md">
      <h1><code>&lt;h1&gt;</code> Heading</h1>

      <h2><code>&lt;h2&gt;</code> Heading</h2>

      <h3><code>&lt;h3&gt;</code> Heading</h3>

      <h4><code>&lt;h4&gt;</code> Heading</h4>

      <h5><code>&lt;h5&gt;</code> Heading</h5>

      <h6><code>&lt;h6&gt;</code> Heading</h6>
    </div> <!-- .col -->

    <div class="col-md">

      <p>We can interchange heading tag with different heading class. For example. <code class="alert-info">&lt;h5 class="h1"&gt;</code> It will use h5 tag but h1 styling will be applied. Generally useful for SEO.</p>

      <p>You might have noticed all the monospaced text in this guide. There are a number of inline <abbr title="HyperText Markup Language">HTML</abbr> elements you may use anywhere within other elements, including <abbr title="Abbreviation">abbr</abbr>, <cite>cite</cite>, <code>code</code>, <del>del</del>, <em>em</em>, <ins>ins</ins>, <strong>strong</strong>, <var>var</var>, and <a href="#" title="link">link</a></p>

    </div> <!-- .col -->

    </div> <!-- .row -->
</div> <!-- .typography-section -->

<hr class="mb-9" />

<h3>Horizontal Rule</h3>
<code>&lt;hr&gt; OR &lt;hr class="hr"&gt;</code>
<hr class="mb-9">

<h3 class="mb-4">Lists</h3>

<div class="row mb-5">

<div class="col">
  <h5>Ordered List <code>&lt;ol&gt;</code></h5>
  <ol>
    <li>List Item</li>
    <li>List Item</li>
    <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu.</li>
    <ol>
      <li>List Item</li>
      <li>List Item</li>
      <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu.</li>
    </ol>
  </ol>
</div> <!-- .col -->

<div class="col">
  <h5>Unordered List <code>&lt;ul&gt;</code></h5>
  <ul>
    <li>List Item</li>
    <li>List Item</li>
    <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu.</li>
      <ul>
        <li>List Item</li>
        <li>List Item</li>
        <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu.</li>
      </ul>
  </ul>
</div> <!-- .col -->

</div> <!-- .row -->

<div class="row">
  <div class="col">
    <h5>Definition List List <code>&lt;dl&gt;</code></h5>
    <dl>
       <dt>Definition list</dt>
       <dd>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
    aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
    commodo consequat.</dd>
       <dt>Lorem ipsum dolor sit amet</dt>
       <dd>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
    aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
    commodo consequat.</dd>
    </dl>
  </div> <!-- .col -->
</div> <!-- .row -->

<hr class="hr mb-9">

<h3 class="mb-4">Table</h3>

<div class="row mb-3">

  <div class="col">
  <table>
    <caption><b>Default</b> <code>&lt;table&gt;</code></caption>
    <thead>
      <tr>
        <th scope="col">Heading</th>
        <th scope="col">Heading</th>
        <th scope="col">Heading</th>
        <th scope="col">Heading</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Table Cell</td>
        <td>Table Cell</td>
        <td>Table Cell</td>
        <td>Table Cell</td>
      </tr>
      <tr>
        <td>Table Cell</td>
        <td>Table Cell</td>
        <td>Table Cell</td>
        <td>Table Cell</td>
      </tr>
      <tr>
        <td>Table Cell</td>
        <td>Table Cell</td>
        <td>Table Cell</td>
        <td>Table Cell</td>
      </tr>
    </tbody>
  </table>
  </div> <!-- .col -->

  <div class="col">
    <table class="table-hover">
      <caption><b>Hover</i></b> <code>&lt;table class="table-hover"&gt;</code></caption>
      <thead>
        <tr>
          <th scope="col">Heading</th>
          <th scope="col">Heading</th>
          <th scope="col">Heading</th>
          <th scope="col">Heading</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
        </tr>
        <tr>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
        </tr>
        <tr>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
        </tr>
      </tbody>
    </table>
  </div> <!-- .col -->

</div> <!-- .row -->

<div class="row mb-3">

  <div class="col">
    <table class="table-bordered">
      <caption><b>Bordered</b> <code>&lt;table class="table-bordered"&gt;</code></caption>
      <thead>
        <tr>
          <th scope="col">Heading</th>
          <th scope="col">Heading</th>
          <th scope="col">Heading</th>
          <th scope="col">Heading</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
        </tr>
        <tr>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
        </tr>
        <tr>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
        </tr>
      </tbody>
    </table>

  </div> <!-- .col -->

  <div class="col">
    <table class="table-striped">
      <caption><b>Striped</b> <code>&lt;table class="table-striped"&gt;</code></caption>
      <thead>
        <tr>
          <th scope="col">Heading</th>
          <th scope="col">Heading</th>
          <th scope="col">Heading</th>
          <th scope="col">Heading</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
        </tr>
        <tr>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
        </tr>
        <tr>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
          <td>Table Cell</td>
        </tr>
      </tbody>
    </table>
  </div> <!-- .col -->

</div> <!-- .row -->

<table class="table-mixed table-hover">
  <caption><b>Mixed & Hover</b> <code>&lt;table class="table-mixed table-hover"&gt;</code></caption>
  <thead>
    <tr>
      <th scope="col">Heading</th>
      <th scope="col">Heading</th>
      <th scope="col">Heading</th>
      <th scope="col">Heading</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Table Cell</td>
      <td>Table Cell</td>
      <td>Table Cell</td>
      <td>Table Cell</td>
    </tr>
    <tr>
      <td>Table Cell</td>
      <td>Table Cell</td>
      <td>Table Cell</td>
      <td>Table Cell</td>
    </tr>
    <tr>
      <td>Table Cell</td>
      <td>Table Cell</td>
      <td>Table Cell</td>
      <td>Table Cell</td>
    </tr>
  </tbody>
</table>

<hr class="mb-9">


<h3 class="mb-3">Alerts</h3>

<code class="mb-1">&lt;div class="alert alert-info"&gt;</code>
<div class="alert alert-info mb-2">
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id, similique?</p>
</div> <!-- .alert -->

<code class="mb-1">&lt;div class="alert alert-error"&gt;</code>
<div class="alert alert-error mb-2">
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id, similique?</p>
</div> <!-- .alert -->

<code class="mb-1">&lt;div class="alert alert-success"&gt;</code>
<div class="alert alert-success mb-2">
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id, similique?</p>
</div> <!-- .alert -->

<hr class="mb-9">


<h3 class="mb-3">Image Alignments</h3>

<div class="row">

  <div class="col">
    <h5>Left <code>&lt;img class="align-left"&gt;</code></h5>
    <div class="mb-2">
      <img src="http://placehold.it/150/ff2500/ffffff&text=368" class="align-left">
    </div> <!-- .mb-2 -->
  </div> <!-- .col -->

  <div class="col">
    <h5>Right <code>&lt;img class="align-right"&gt;</code></h5>
    <div class="mb-2">
      <img src="http://placehold.it/150/ff2500/ffffff&text=368" class="align-right">
    </div> <!-- .mb-2 -->
  </div> <!-- .col -->

</div> <!-- .row -->

<h5>Center <code>&lt;img class="align-center"&gt;</code></h5>
<div class="mb-2">
  <img src="http://placehold.it/150/ff2500/ffffff&text=368" class="alignright">
</div> <!-- .mb-2 -->

<hr class="hr">

<h2>Buttons</h2>

<div class="row">
  <div class="col">
    <h5>Primary</h5>
    <p>
      <a href="#" class="btn btn-primary btn-xs">Extra Small</a>
      <a href="#" class="btn btn-primary btn-sm">Small</a>
      <a href="#" class="btn btn-primary btn-md">Medium</a>
      <a href="#" class="btn btn-primary btn-lg">Large</a>
      <a href="#" class="btn btn-primary btn-xlg">Extra Large</a>
    </p>
  </div> <!-- .col -->

  <div class="col">
    <h5>Secondary</h5>
    <p>
      <a href="#" class="btn btn-secondary btn-xs">Extra Small</a>
      <a href="#" class="btn btn-secondary btn-sm">Small</a>
      <a href="#" class="btn btn-secondary btn-md">Medium</a>
      <a href="#" class="btn btn-secondary btn-lg">Large</a>
      <a href="#" class="btn btn-secondary btn-xlg">Extra Large</a>
    </p>
  </div> <!-- .col -->
</div> <!-- .row -->

<hr class="hr">

<h2>Social Icons (With Tooltips)</h2>

<ul class="list-socials clearfix">
  <li class="icon-facebook"><a href="<?php echo @$facebook; ?>"><span class="tooltip">@tooltip</span>Facebook</a></li>
  <li class="icon-twitter"><a href="<?php echo @$twitter; ?>"><span class="tooltip">@tooltip</span>Twitter</a></li>
  <li class="icon-instagram"><a href="<?php echo @$instagram; ?>"><span class="tooltip">@tooltip</span>Instagram</a></li>
  <li class="icon-gplus"><a href="<?php echo @$instagram; ?>"><span class="tooltip">@tooltip</span>Google Plus</a></li>
  <li class="icon-pinterest"><a href="<?php echo @$instagram; ?>"><span class="tooltip">@tooltip</span>Pinterest</a></li>
  <li class="icon-youtube"><a href="<?php echo @$instagram; ?>"><span class="tooltip">@tooltip</span>Youtube</a></li>
  <li class="icon-linkedin"><a href="<?php echo @$instagram; ?>"><span class="tooltip">@tooltip</span>Linkedin</a></li>
</ul> <!-- .list-socials -->

<hr class="hr">

<h2>Bootstrap Grid <em>(only)</em></h2>
<p>Please refer to <a href="http://getbootstrap.com/css/">http://getbootstrap.com/css/#grid</a></p>

<hr class="hr">

<h2>Gravity Form</h2>

<?php gravity_form(1, $display_title=false, $display_description=false, $display_inactive=false, $field_values=null, $ajax=true, $tabindex=10); ?>

</div> <!-- .container-fluid -->

<?php get_footer(); ?>