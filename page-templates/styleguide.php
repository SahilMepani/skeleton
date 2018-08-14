<?php /* Template Name: Styleguide */ ?>

<?php get_header(); ?>

<div class="container py-4">

<div class="row">

<div class="col">
	<h1><code>&lt;h1&gt;</code> Heading</h1>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores tempore amet aut reiciendis illum necessitatibus.</p>

	<h2><code>&lt;h2&gt;</code> Heading</h2>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores tempore amet aut reiciendis illum necessitatibus.</p>

	<h3><code>&lt;h3&gt;</code> Heading</h3>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores tempore amet aut reiciendis illum necessitatibus.</p>

	<h4><code>&lt;h4&gt;</code> Heading</h4>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores tempore amet aut reiciendis illum necessitatibus.</p>

	<h5><code>&lt;h5&gt;</code> Heading</h5>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores tempore amet aut reiciendis illum necessitatibus.</p>

	<h6><code>&lt;h6&gt;</code> Heading</h6>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores tempore amet aut reiciendis illum necessitatibus.</p>
</div> <!-- .col -->

<div class="col">

	<h4>Article</h4>

	<p>You might have noticed all the monospaced text in this guide. There are a number of inline <abbr title="HyperText Markup Language">HTML</abbr> elements you may use anywhere within other elements, including <abbr title="Abbreviation">abbr</abbr>, <cite>cite</cite>, <code>code</code>, <del>del</del>, <em>em</em>, <ins>ins</ins>, <strong>strong</strong>, <var>var</var>, and <a href="#" title="link">link</a></p>

	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur tempore eveniet consequatur illum ipsam impedit.</p>

	<h4>Heading between copy</h4>

	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime aliquam perferendis a, praesentium, placeat commodi rerum tempore officiis et quo. Omnis itaque optio maxime saepe.</p>

	<hr>

	<h5>Blockquote</h5>

	<blockquote cite="http://en.wikipedia.org/wiki/Gall%27s_law">
		<p>A complex system that works is invariably found to have evolved from a simple system that worked. The inverse proposition also appears to be true: <em>A complex system designed from scratch never works</em> and cannot be made to work. You have to start over, beginning with a working simple system.</p>
		<footer>
			<p><a href="http://en.wikipedia.org/wiki/Gall%27s_law">http://en.wikipedia.org/wiki/Gall%27s_law</a></p>
		</footer>
	</blockquote>

	<blockquote>
		<p><em>Simplicity</em> is the ultimate sophistication.</p>
		<footer>
			<p>&mdash; LEONARDO DA VINCI</p>
		</footer>
	</blockquote>
</div> <!-- .col -->

</div> <!-- .row -->

<h5><b>Horizontal Rule</b> <code>&lt;hr&gt; OR &lt;hr class="hr"&gt;</code></h5>
<hr>

<h2>Lists</h2>

<div class="row">

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
</div> <!-- .row col-sm-12 -->

<hr class="hr">

<h2>Table</h2>

<div class="row margin-bottom-2">

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

<div class="row">

	<div class="col">
		<table class="table-bordered margin-bottom-2">
			<caption><b>Bordered</b> <code>&lt;table class="table-expanded table-bordered"&gt;</code></caption>
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
		<table class="table-expanded table-striped margin-bottom-2">
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

<hr class="hr">

<h2>Image Alignments</h2>

<div class="row margin-bottom-2">

	<div class="col">
		<h5>Left <code>&lt;img class="align-left"&gt;</code></h5>
		<img src="http://placehold.it/150/f15500/ffffff&text=368" class="align-left">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, culpa, officiis, recusandae minus qui autem labore eveniet ullam praesentium maxime vel eos nam! Voluptatem, iste, suscipit sit quidem veritatis vitae animi fugit numquam doloribus nemo non fugiat quibusdam laboriosam a quis deleniti minima cum repudiandae sint officiis maxime necessitatibus voluptas.</p>
	</div> <!-- .col -->

	<div class="col">
		<h5>Right <code>&lt;img class="align-right"&gt;</code></h5>
		<img src="http://placehold.it/150/f15500/ffffff&text=368" class="align-right">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, culpa, oRightficiis, recusandae minus qui autem labore eveniet ullam praesentium maxime vel eos nam! Voluptatem, iste, suscipit sit quidem veritatis vitae animi fugit numquam doloribus nemo non fugiat quibusdam laboriosam a quis deleniti minima cum repudiandae sint officiis maxime necessitatibus voluptas.</p>
	</div> <!-- .col -->

</div> <!-- .row -->

<h5>Center <code>&lt;img class="align-center"&gt;</code></h5>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, quos, deserunt obcaecati sapiente vero repellendus vel alias doloremque nam magnam quidem dolore consequuntur. Inventore, illum.</p>

<img src="http://placehold.it/150/f15500/ffffff&text=368" class="align-center">

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, quos, deserunt obcaecati sapiente vero repellendus vel alias doloremque nam magnam quidem dolore consequuntur. Inventore, illum.</p>

<h5>Image with Frame <code>&lt;img class="img-thumbnail"&gt;</code></h5>

<p><img src="http://placehold.it/150/f15500/ffffff&text=368" class="img-thumbnail"></p>

<hr class="hr">

<h2>Alerts</h2>

<h5><code>&lt;div class="alert"&gt;</code></h5>
<div class="alert">
	<h5>Alert</h5>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, placeat perspiciatis facere expedita quae rem similique voluptatem animi dicta debitis excepturi nobis corporis nam totam.</p>
</div>

<h5><code>&lt;div class="alert alert--info"&gt;</code></h5>
<div class="alert alert--info">
	<h5>Info Alert</h5>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, placeat perspiciatis facere expedita quae rem similique voluptatem animi dicta debitis excepturi nobis corporis nam totam.</p>
</div>

<h5><code>&lt;div class="alert alert--error"&gt;</code></h5>
<div class="alert alert--error">
	<h5>Error Alert</h5>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, placeat perspiciatis facere expedita quae rem similique voluptatem animi dicta debitis excepturi nobis corporis nam totam.</p>
</div>

<h5><code>&lt;div class="alert alert--success"&gt;</code></h5>
<div class="alert alert--success">
	<h5>Success Alert</h5>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, placeat perspiciatis facere expedita quae rem similique voluptatem animi dicta debitis excepturi nobis corporis nam totam.</p>
</div>

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