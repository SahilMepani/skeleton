<?php /* Template Name: Styleguide */ ?>

<?php get_header(); ?>

<div class="container py-4">

<section class="typography">

  <h3 class="mb-4">Typography</h3>

  <div class="row">

    <div class="col-md">
      <h1><code>&lt;h1&gt;</code> Heading</h1>

      <h2><code>&lt;h2&gt;</code> Heading</h2>

      <h3><code>&lt;h3&gt;</code> Heading</h3>

      <h4><code>&lt;h4&gt;</code> Heading</h4>

      <h5><code>&lt;h5&gt;</code> Heading</h5>

      <h6><code>&lt;h6&gt;</code> Heading</h6>

      <p>We can interchange heading tag with different heading class. For example. <code class="alert-info">&lt;h5 class="h1"&gt;</code> It will use h5 tag but h1 styling will be applied. Generally useful for SEO.</p>

      <h4 class="mb-3">Paragraphs</h4>

      <code class="mb-1">&lt;p&gt;</code>
      <div class="mb-3">
        <p>This para has default font-size. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, magnam.</p>
      </div> <!-- .text-left -->

      <code class="mb-1">&lt;div class="text-big"&gt;</code>
      <div class="text-big mb-3">
        <p>This para is big in font-size. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, magnam.</p>
      </div> <!-- .text-left -->

      <code class="mb-1">&lt;div class="text-small"&gt;</code>
      <div class="text-small mb-3">
        <p>This para is small in font-size. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, magnam.</p>
      </div> <!-- .text-left -->


    </div> <!-- .col -->

    <div class="col-md">

      <p>You might have noticed all the monospaced text in this guide. There are a number of inline <abbr title="HyperText Markup Language">HTML</abbr> elements you may use anywhere within other elements, including <abbr title="Abbreviation">abbr</abbr>, <cite>cite</cite>, <code>code</code>, <del>del</del>, <em>em</em>, <ins>ins</ins>, <strong>strong</strong>, <var>var</var>, and <a href="#" title="link">link</a></p>

      <h4 class="mb-3">Text Alignment</h4>

      <code class="mb-1">&lt;div class="text-left"&gt;</code>
      <div class="text-left mb-3">
        <p>This text is align left</p>
      </div> <!-- .text-left -->

      <code class="mb-1">&lt;div class="text-right"&gt;</code>
      <div class="text-right mb-3">
        <p>This text is align right</p>
      </div> <!-- .text-right -->

      <code class="mb-1">&lt;div class="text-center"&gt;</code>
      <div class="text-center mb-3">
        <p>This text is align center</p>
      </div> <!-- .text-center -->

      <code class="mb-1">&lt;div class="text-justify"&gt;</code>
      <div class="text-justify mb-3">
        <p>This text is justified. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi, fugit.</p>
      </div> <!-- .text-center -->

    </div> <!-- .col -->

    </div> <!-- .row -->
</section>

<hr class="mb-9" />

<section class="buttons">
  <h3 class="mb-3">Buttons</h3>

  <div class="row">

    <div class="col">
      <h4>Sizes</h4>
      <code class="mb-1">&lt;a class="btn btn-sm"&gt;</code>
      <div class="mb-2"><a href="#" class="btn btn-primary btn-sm">Small</a></div>
      <code class="mb-1">&lt;btn class="btn btn-md"&gt; - notice btn tag</code>
      <div class="mb-2"><btn class="btn btn-primary btn-md">Medium</btn></div>
      <code class="mb-1">&lt;a class="btn btn-lg"&gt;</code>
      <div class="mb-2"><a href="#" class="btn btn-primary btn-lg">Large</a></div>
      <code class="mb-1">&lt;a class="btn btn-md d-block"&gt;</code>
      <div class="mb-2"><a href="#" class="btn btn-primary btn-md d-block">Block - Medium</a></div>
      <p>It will cover the entire width of the container.</p>
    </div> <!-- .col -->

    <div class="col">
      <h4>Colors</h4>

      <code class="mb-1">&lt;btn class="btn btn-primary btn-md"&gt;</code>
      <div class="mb-2"><btn class="btn btn-primary btn-md">Medium</btn></div>

      <code class="mb-1">&lt;btn class="btn btn-secondary btn-lg"&gt;</code>
      <div class="mb-2"><btn class="btn btn-secondary btn-lg">Large</btn></div>

      <p>We can mix and match the sizes and color classes.</p>

      <h4>Disabled</h4>

      <code class="mb-1">&lt;btn class="btn btn-primary btn-md btn-disabled"&gt;</code>
      <div class="mb-2"><btn class="btn btn-primary btn-md btn-disabled">Medium</btn></div>

    </div> <!-- .col -->
  </div> <!-- .row -->
</section>

<hr class="mb-9">

<section class="spacing">
  <h3 class="mb-3">Spacing</h3>

  <div class="row mb-4">

    <div class="col">
      <p>The margin classes are used to create space around elements, outside of any defined borders. There are classes for setting the margin for each side of an element (top, right, bottom, and left).</p>

      <p><b>m-(number)</b> <br /> Set margin for all four sides (top, right, bottom, and left).</p>
      <p><b>mt-(number)</b> <br /> Sets the top margin of an element</p>
      <p><b>mr-(number)</b> <br /> Sets the right margin of an element</p>
      <p><b>mb-(number)</b> <br /> Sets the bottom margin of an element</p>
      <p><b>ml-(number)</b> <br /> Sets the left margin of an element</p>

      <code class="mb-1">&lt;div class="mb-3"&gt;</code>
      <div class="bg-gray mb-3">I've a margin bottom of 30px</div>

      <code class="mb-1">&lt;div class="mb-2"&gt;</code>
      <div class="bg-gray mb-2">I've a margin bottom of 20px</div>

      <div class="bg-gray">Dummy Text</div>


      <div class="bg-gray mt-4 mr-3 mb-2 ml-1">
        <code class="mb-1">&lt;div class="mt-4 mt-3 mb-2 ml-1"&gt;</code> <br />
        <p>I've a margin of 40px at top, 30px at right, 20px at bottom and 10px at left</p>
      </div>

      <div class="bg-gray">Dummy Text</div>
    </div> <!-- .col -->

    <div class="col">
      <p>The padding classes are used to generate space around an element's content, inside of any defined borders. There are classes for setting the classes for each side of an element (top, right, bottom, and left).</p>

      <p><b>p-(number)</b> <br /> Set padding for all four sides (top, right, bottom, and left).</p>
      <p><b>pt-(number)</b> <br /> Sets the top padding of an element</p>
      <p><b>pr-(number)</b> <br /> Sets the right padding of an element</p>
      <p><b>pb-(number)</b> <br /> Sets the bottom padding of an element</p>
      <p><b>pl-(number)</b> <br /> Sets the left padding of an element</p>

      <code class="mb-1">&lt;div class="p-3"&gt;</code>
      <div class="bg-gray p-3 mb-2">I've a padding of 30px at each side</div>

      <code class="mb-1">&lt;div class="pb-2"&gt;</code>
      <div class="bg-gray p-2 mb-2">I've a padding of 20px at each side</div>

      <code class="mb-1">&lt;div class="pt-2 pr-1-5 pb-3 pl-2-5"&gt;</code>
      <div class="bg-gray pt-2 pr-1-5 pb-3 pl-2-5 mb-2"><p>I've a padding of 20px at top, 15px at right, 50px at bottom and 25px at left</p></div>
    </div> <!-- .col -->

  </div> <!-- .row -->

  <p>(number) can be replaced by any number starting from 0-5 to 20 at an interval of .5. For eg. 0-5, 1, 1-5, 2, 2-5 etc.</p>

  <p>Each number gets multiplied by 10px. So a class "mr-2" will set margin of 20px to the right of the element</p>
</section>

<hr class="mb-9">

<section class="alerts">
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
</section>

<hr class="mb-9">

<section class="grid">
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

  <code class="p-1 mb-1">&lt;div class="col-1"&gt;</code>
  <div class="row text-center mb-3">
    <div class="col-1">
      <div class="bg-gray p-2">Hi</div>
    </div>
  </div> <!-- .row -->

  <code class="p-1 mb-1">&lt;div class="col-2"&gt;</code>
  <div class="row text-center mb-3">
    <div class="col-2"><div class="bg-gray p-2">Hi</div></div>
  </div> <!-- .row -->

  <code class="p-1 mb-1">&lt;div class="col-3"&gt;</code>
  <div class="row text-center mb-3">
    <div class="col-3"><div class="bg-gray p-2">Hi</div></div>
  </div> <!-- .row -->

  <code class="p-1 mb-1">&lt;div class="col-4"&gt;</code>
  <div class="row text-center mb-3">
    <div class="col-4"><div class="bg-gray p-2">Hi</div></div>
  </div> <!-- .row -->

  <code class="p-1 mb-1">&lt;div class="col-5"&gt;</code>
  <div class="row text-center mb-3">
    <div class="col-5"><div class="bg-gray p-2">Hi</div></div>
  </div> <!-- .row -->

  <code class="p-1 mb-1">&lt;div class="col-6"&gt;</code>
  <div class="row text-center mb-3">
    <div class="col-6"><div class="bg-gray p-2">Hi</div></div>
  </div> <!-- .row -->

  <p>It can go till <code>&lt;div class="col-12"&gt;</code></p>
</section>

<hr class="mb-9" />

<section class="horizontal-rule">
  <h3>Horizontal Rule</h3>
  <code>&lt;hr&gt;</code>
</section>

<hr class="mb-9">

<section class="list">
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
      <h5>Definition List <code>&lt;dl&gt;</code></h5>
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
</section>

<hr class="mb-9">

<section class="table">
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

  <table class="table-striped table-bordered table-hover">
    <caption><b>Mixed</b> <code>&lt;table class="table-striped table-bordered table-hover"&gt;</code></caption>
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
</section>

<hr class="mb-9">

<?php //gravity_form(1, $display_title=false, $display_description=false, $display_inactive=false, $field_values=null, $ajax=true, $tabindex=10); ?>

</div> <!-- .container-fluid -->

<?php get_footer(); ?>