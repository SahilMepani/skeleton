@use 'util' as *;
@use 'util-assets' as *;

@use 'abstract/colors';
@use 'abstract/fonts';
@use 'abstract/transitions';
@use 'abstract/custom';
@use 'config';

.core-component-{%= it.slug %} {
<%= contents %>
}

{% it.styles.forEach( function ( styleName ) { %}
.core-component-{%= it.slug %}.style-{%= styleName %} {
	@import './styles/_{%= styleName %}';
}
{% }) %}
