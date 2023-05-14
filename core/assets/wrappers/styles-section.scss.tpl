@use 'util' as *;
@use 'util-assets' as *;

@use 'abstract/colors';
@use 'abstract/fonts';
@use 'abstract/transitions';
@use 'abstract/custom';
@use 'config';

.core-section-library-wrapper .core-section-{%= it.slug %} {
<%= contents %>
}
