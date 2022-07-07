<?php /* Template Name: Styleguide */ ?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <!-- HTML Boilerplte v8.00 -->
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php wp_title( '-', true, 'right' ); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class( 'site-wrapper' ); ?>>

<?php wp_body_open(); ?>

<div class="container py-4">

<div class="fs-4 mb-1 text-gray-600 fw-bold">Base Colors</div>

<hr class="mb-4">

<ul class="row row-cols-4 gx-1 mx-n0-5 list-unstyled mb-10">
  <li class="mb-1">
    <div class="bg-primary text-white d-flex flex-column align-content-between py-1-5 px-2">
      <div class="fs-4 mb-7">blue</div>
    </div>
  </li>
  <li class="mb-1">
    <div class="bg-indigo text-white d-flex flex-column align-content-between py-1-5 px-2">
      <div class="fs-4 mb-7">indigo</div>
    </div>
  </li>
  <li class="mb-1">
    <div class="bg-purple text-white d-flex flex-column align-content-between py-1-5 px-2">
      <div class="fs-4 mb-7">purple</div>
    </div>
  </li>
  <li class="mb-1">
    <div class="bg-pink text-white d-flex flex-column align-content-between py-1-5 px-2">
      <div class="fs-4 mb-7">pink</div>
    </div>
  </li>
  <li class="mb-1">
    <div class="bg-red text-white d-flex flex-column align-content-between py-1-5 px-2">
      <div class="fs-4 mb-7">red</div>
    </div>
  </li>
</ul> <!-- .mb-10 -->

<div class="fs-4 mb-1 text-gray-600 fw-bold">Accent Colors</div>

<hr class="mb-4">

<ul class="row row-cols-4 gx-1 mx-n0-5 list-unstyled mb-10">
  <li class="mb-1">
    <div class="bg-orange text-white d-flex flex-column align-content-between py-1-5 px-2">
      <div class="fs-4 mb-7">orange</div>
    </div>
  </li>
  <li class="mb-1">
    <div class="bg-yellow text-white d-flex flex-column align-content-between py-1-5 px-2">
      <div class="fs-4 mb-7">yellow</div>
    </div>
  </li>
  <li class="mb-1">
    <div class="bg-green text-white d-flex flex-column align-content-between py-1-5 px-2">
      <div class="fs-4 mb-7">green</div>
    </div>
  </li>
  <li class="mb-1">
    <div class="bg-teal text-white d-flex flex-column align-content-between py-1-5 px-2">
      <div class="fs-4 mb-7">teal</div>
    </div>
  </li>
  <li class="mb-1">
    <div class="bg-cyan text-white d-flex flex-column align-content-between py-1-5 px-2">
      <div class="fs-4 mb-7">cyan</div>
    </div>
  </li>
</ul> <!-- .mb-10 -->

<div class="row row-cols-2 gx-5 mb-10">
  <div class="col">
		<div class="fs-4 mb-1 text-gray-600 fw-bold">DESKTOP TYPOGRAPHY</div>
		<hr class="mb-4">
    <div class="d-block text-gray-500 fw-bold mb-1">H1</div>
    <div class="h1 mb-4">This is a heading and it needs to span two lines to get an idea about line-height too</div>
    <div class="d-block text-gray-500 fw-bold mb-1">H2</div>
    <div class="h2 mb-4">Make sure font-weight and letter spacing matches the heading too please</div>
    <div class="d-block text-gray-500 fw-bold mb-1">H3</div>
    <div class="h3 mb-4">Heading Three</div>
    <div class="d-block text-gray-500 fw-bold mb-1">H4</div>
    <div class="h4 mb-4">Heading Four</div>
    <div class="d-block text-gray-500 fw-bold mb-1">H5</div>
    <div class="h5 mb-4">Heading Five</div>
    <div class="d-block text-gray-500 fw-bold mb-1">H6</div>
    <div class="h6 mb-4">Heading Six</div>
		<div class="d-block fw-bold text-gray-500 mb-1">Display 1</div>
    <div class="display-1 mb-4">Lora Large</div>
    <div class="d-block fw-bold text-gray-500 mb-1">Display 2</div>
    <div class="display-2 mb-4">Lora Large</div>
    <div class="d-block fw-bold text-gray-500 mb-1">Display 3</div>
    <div class="display-3 mb-4">Lora Large</div>
		<div class="d-block mb-2 fw-bold text-gray-500">BODY</div>
    <p>There should be two paragraph stacked on top of each other to get an idea about the spacing required between them.</p>
    <p class="mb-6">You might have noticed all the monospaced text in this guide. There are a number of inline <abbr title="HyperText Markup Language">HTML</abbr> elements you may use anywhere within other elements, including <abbr title="Abbreviation">abbr</abbr>, <cite>cite</cite>, <code>code</code>, <del>del</del>, <em>em</em>, <ins>ins</ins>, <strong>strong</strong>, <var>var</var>, and <a href="#" title="link">link</a></p>

    <div class="d-block mb-2 fw-bold text-gray-500">LEAD</div>
    <p class="mb-6 lead">
      This is a lead paragraph. It stands out from regular paragraphs.
    </p>

    <div class="d-block mb-2 fw-bold text-gray-500">BLOCKQUOTES</div>
    <figure class="mb-6">
      <blockquote class="blockquote">
        <p>A well-known quote, contained in a blockquote element.</p>
      </blockquote>
      <figcaption class="blockquote-footer">
        Someone famous in <cite title="Source Title">Source Title</cite>
      </figcaption>
    </figure>
  </div> <!-- .col -->
	<div class="col">
		<div class="fs-4 mb-1 text-gray-600 fw-bold">MOBILE TYPOGRAPHY</div>
		<hr class="mb-4">
    <div class="d-block text-gray-500 fw-bold mb-1">H1</div>
    <div class="h2 mb-4">This is a heading and it needs to span two lines to get an idea about line-height too</div>
    <div class="d-block text-gray-500 fw-bold mb-1">H2</div>
    <div class="h3 mb-4">Make sure font-weight and letter spacing matches the heading too please</div>
    <div class="d-block text-gray-500 fw-bold mb-1">H3</div>
    <div class="h4 mb-4">Heading Three</div>
    <div class="d-block text-gray-500 fw-bold mb-1">H4</div>
    <div class="h5 mb-4">Heading Four</div>
    <div class="d-block text-gray-500 fw-bold mb-1">H5</div>
    <div class="h6 mb-4">Heading Five</div>
    <div class="d-block text-gray-500 fw-bold mb-1">H6</div>
    <div class="h6 mb-4">Heading Six</div>
		<div class="d-block fw-bold text-gray-500 mb-1">Display 1</div>
    <div class="display-2 mb-4">Lora Large</div>
    <div class="d-block fw-bold text-gray-500 mb-1">Display 2</div>
    <div class="display-3 mb-4">Lora Large</div>
    <div class="d-block fw-bold text-gray-500 mb-1">Display 3</div>
    <div class="display-4 mb-4">Lora Large</div>
		<div class="d-block mb-2 fw-bold text-gray-500">BODY</div>
    <p>There should be two paragraph stacked on top of each other to get an idea about the spacing required between them.</p>
    <p class="mb-6">You might have noticed all the monospaced text in this guide. There are a number of inline <abbr title="HyperText Markup Language">HTML</abbr> elements you may use anywhere within other elements, including <abbr title="Abbreviation">abbr</abbr>, <cite>cite</cite>, <code>code</code>, <del>del</del>, <em>em</em>, <ins>ins</ins>, <strong>strong</strong>, <var>var</var>, and <a href="#" title="link">link</a></p>

    <div class="d-block mb-2 fw-bold text-gray-500">LEAD</div>
    <p class="mb-6 lead">
      This is a lead paragraph. It stands out from regular paragraphs.
    </p>

    <div class="d-block mb-2 fw-bold text-gray-500">BLOCKQUOTES</div>
    <figure class="mb-6">
      <blockquote class="blockquote">
        <p>A well-known quote, contained in a blockquote element.</p>
      </blockquote>
      <figcaption class="blockquote-footer">
        Someone famous in <cite title="Source Title">Source Title</cite>
      </figcaption>
    </figure>
  </div> <!-- .col -->
</div> <!-- .row row-cols-2 gx-5 -->

<div class="fs-4 mb-1 text-gray-600 fw-bold">Buttons</div>

<hr class="mb-4">

<div class="d-block mb-2 fw-bold text-gray-500">STYLES</div>

<div class="mb-6 row row-cols-auto gx-2">
  <div>
    <button type="button" class="btn btn-primary">Button Primary</button>
  </div>
  <div>
    <button type="button" class="btn btn-outline-primary">Button Outline Primary</button>
  </div>
</div> <!-- .mb-6 -->

<div class="d-block mb-2 fw-bold text-gray-500">SIZES</div>

<div class="mb-6 row row-cols-auto gx-2">
  <div>
    <button type="button" class="btn btn-primary btn-sm">Button Small</button>
  </div>
  <div>
    <button type="button" class="btn btn-primary">Button Default</button>
  </div>
  <div>
    <button type="button" class="btn btn-primary btn-lg">Button Large</button>
  </div>
</div> <!-- .mb-6 -->

<div class="fs-4 mb-1 text-gray-600 fw-bold">Alerts</div>

<hr class="mb-4">

<div class="mb-6">
<div class="bg-info py-1 px-1-5 mb-1">
  Info Alert - Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nesciunt, iste!
</div>
<div class="bg-danger text-white py-1 px-1-5 mb-1">
Error Alert -Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nesciunt, iste!
</div>
<div class="bg-success text-white py-1 px-1-5 mb-1">
Success Alert -Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nesciunt, iste!
</div>
</div> <!-- .mb-6 -->


<div class="fs-4 mb-1 text-gray-600 fw-bold">Table</div>

<hr class="mb-4">

<div class="row mb-5">

  <div class="col col-md-6 mb-5">
    <div class="d-block mb-2 fw-bold text-gray-500">DEFAULT</div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td colspan="2">Larry the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </table>
  </div> <!-- .col -->

  <div class="col col-md-6 mb-5">
  <div class="d-block mb-2 fw-bold text-gray-500">HOVER</div>
  <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td colspan="2">Larry the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </table>
  </div> <!-- .col -->

  <div class="col col-md-6 mb-5">
    <div class="d-block mb-2 fw-bold text-gray-500">BORDERED</div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td colspan="2">Larry the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </table>
  </div> <!-- .col -->

  <div class="col col-md-6 mb-5">
  <div class="d-block mb-2 fw-bold text-gray-500">BORDERED PRIMARY</div>
    <table class="table table-bordered border-primary">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td colspan="2">Larry the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </table>
  </div> <!-- .col -->

  <div class="col col-md-6 mb-5">
    <div class="d-block mb-2 fw-bold text-gray-500">STRIPED</div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td colspan="2">Larry the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </table>
  </div> <!-- .col -->

  <div class="col col-md-6 mb-5">
  <div class="d-block mb-2 fw-bold text-gray-500">BORDERLESS</div>
    <table class="table table-borderless">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td colspan="2">Larry the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </table>
  </div> <!-- .col -->

  <div class="col col-md-6 mb-5">
  <div class="d-block mb-2 fw-bold text-gray-500">SMALL TABLE</div>
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td colspan="2">Larry the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </table>
  </div> <!-- .col -->

  <div class="col col-md-6 mb-5">
  <div class="d-block mb-2 fw-bold text-gray-500">RESPONSIVE TABLE</div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Heading</th>
            <th scope="col">Heading</th>
            <th scope="col">Heading</th>
            <th scope="col">Heading</th>
            <th scope="col">Heading</th>
            <th scope="col">Heading</th>
            <th scope="col">Heading</th>
            <th scope="col">Heading</th>
            <th scope="col">Heading</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div> <!-- .col -->

</div> <!-- .row -->

<h4>Form</h4>

<?php gravity_form(1, $display_title=false, $display_description=false, $display_inactive=false, $field_values=null, $ajax=true, $tabindex=10); ?>

</div> <!-- .container-fluid -->

<?php get_footer(); ?>