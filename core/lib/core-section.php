<?php
/**
 * Controls the Section Wrapper element.
 *
 * @since 2.18.0
 * @internal
 */
class Core_Section {
	private $slug;
	private $attributes = [];
	private $class_names = [];

	/**
	 * Initializes the section with some configuration.
	 *
	 * @since 2.18.0
	 *
	 * @param string $slug
	 * @param mixed[] [$config=[]]
	 */
	function __construct( $slug, $config = [] ) {
		$this->slug = $slug;

		if ( empty( $config ) ) return;

		$attributes = core_default( 'attributes', $config, [] );

		if ( core_is_assoc( $attributes ) ) {
			$this->attributes = $attributes;
		}

		$class_names = core_default( 'class_names', $config, [] );

		if ( is_string( $class_names ) ) {
			$class_names = [ $class_names ];
		}

		if ( is_array( $class_names ) ) {
			$this->class_names = $class_names;
		}
	}

	/**
	 * Adds the specified attribute to the section.
	 *
	 * @since 2.18.0
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function set_attr( $name, $value ) {
		if ( $value && ( is_string( $value ) || is_numeric( $value ) ) ) {
			$this->attributes[ $name ] = $value;
		}
	}

	/**
	 * Adds a collection of attributes to the section.
	 *
	 * @since 2.18.0
	 *
	 * @param mixed[] $attributes
	 */
	public function set_attr_array( $attributes ) {
		if ( ! core_is_assoc( $attributes ) ) return;

		$attributes = array_filter( $attributes );

		foreach ( $attributes as $name => $value ) {
			$this->set_attr( $name, $value );
		}
	}

	/**
	 * Adds a single or multiple classes to the section.
	 *
	 * @since 2.18.0
	 *
	 * @param string|string[] $class_name
	 */
	public function add_class( $class_name ) {
		if ( is_array( $class_name ) ) {
			$class_name = join( ' ', $class_name );
		}

		if ( is_string( $class_name ) ) {
			$this->class_names[] = $class_name;
		}
	}

	/**
	 * Generates the section node as an HTML string.
	 *
	 * @since 2.18.0
	 *
	 * @param string [$contents=""]
	 * @return string
	 */
	public function generate_node( $contents = '' ) {
		$attrs = [];

		// * Main Attributes
		if ( ! empty( $this->attributes ) ) {
			$attributes = array_filter( $this->attributes );

			foreach ( $attributes as $key => $value ) {
				$attrs[] = "{$key}='{$value}'";
			}
		}

		// * Class Names
		array_unshift( $this->class_names, "core-section core-section-{$this->slug} {$this->slug}" );
		$this->class_names[] = "js-core-section-{$this->slug}";

		if ( ! empty( $this->class_names ) ) {
			$class_names = join( ' ', array_filter( $this->class_names ) );
			$attrs[] = "class='{$class_names}'";
		}

		$contents = is_string( $contents ) ? trim( $contents ) : '';
		$wrapper_tag = "<section ".join( ' ', $attrs ).">{$contents}</section>";

		return $wrapper_tag;
	}
}
