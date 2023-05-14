<?php
/**
 * Controls the Component Wrapper element.
 *
 * @since 2.12.0
 * @internal
 */
class Core_Component {
	private $slug;
	private $data;
	private $node_type = 'div';
	private $attributes = [];
	private $class_names = [];

	/**
	 * Initializes the component with some data and configuration.
	 *
	 * @since 2.12.0
	 *
	 * @param string $slug
	 * @param mixed[] $data
	 * @param mixed[] [$config=[]]
	 */
	function __construct( $slug, $data, $config = [] ) {
		$this->slug = $slug;

		if ( is_array( $data ) ) {
			$this->data = $data;
		}

		if ( empty( $config ) ) return;

		if (
			array_key_exists( 'type', $config ) &&
			is_string( $config['type'] )
		) {
			$this->node_type = $config['type'];
		}

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
	 * Sets the node type.
	 *
	 * @since 2.12.0
	 *
	 * @param string $type
	 */
	public function set_type( $type ) {
		$this->node_type = $type;
	}

	/**
	 * Adds the specified attribute to the component.
	 *
	 * @since 2.12.0
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
	 * Adds a collection of attributes to the component.
	 *
	 * @since 2.12.0
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
	 * Adds the specified data to the component.
	 *
	 * @since 2.12.0
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function set_data( $key, $value ) {
		if ( ! is_string( $key ) ) return;

		$this->data[$key] = $value;
	}

	/**
	 * Adds a collection of data to the component.
	 *
	 * @since 2.12.0
	 *
	 * @param mixed[] $data
	 */
	public function set_data_array( $data ) {
		if ( ! core_is_assoc( $data ) ) return;

		foreach ( $data as $key => $value ) {
			$this->set_data( $key, $value );
		}
	}

	/**
	 * Adds a single or multiple classes to the component.
	 *
	 * @since 2.12.0
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
	 * Retrieves the component data.
	 *
	 * @since 2.12.0
	 *
	 * @return mixed[]
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * Utility used to parse urls, like `mailto:` and `tel:`.
	 *
	 * @since 2.12.0
	 *
	 * @param string $url
	 * @return string
	 */
	public function parse_url( $url ) {

		// ? Mailto Link
		if ( strpos( $url, 'mailto:' ) === 0 ) {
			$mail_params = array_filter([
				'cc' => core_default( 'cc', $this->data, null ),
				'bcc' => core_default( 'bcc', $this->data, null ),
				'subject' => core_default( 'subject', $this->data, null )
			]);

			if ( ! empty( $mail_params ) ) {
				$mail_params = array_map( function( $key, $value ) {
					return "{$key}={$value}";
				}, array_keys( $mail_params ), array_values( $mail_params ) );

				$url = $url.'?'.join( '&', $mail_params );
			}
		}

		// ? Phone Link
		elseif ( strpos( $url, 'tel:' ) === 0 ) {
			$url = preg_replace( '/[\(\)\s\-]+/', '', $url );
		}

		return $url;
	}

	/**
	 * Generates the component node as an HTML string.
	 *
	 * @since 2.12.0
	 *
	 * @param string [$contents=""]
	 * @return string
	 */
	public function generate_node( $contents = '' ) {
		if ( ! $this->node_type ) return null;

		$attrs = [];

		// * Main Attributes
		if ( ! empty( $this->attributes ) ) {
			$attributes = array_filter( $this->attributes );

			foreach ( $attributes as $key => $value ) {
				$attrs[] = "{$key}='{$value}'";
			}
		}

		// * Class Names
		array_unshift( $this->class_names, "core-component core-component-{$this->slug} {$this->slug}" );
		$this->class_names[] = "js-core-component-{$this->slug}";

		if ( ! empty( $this->class_names ) ) {
			$class_names = join( ' ', array_filter( $this->class_names ) );
			$attrs[] = "class='{$class_names}'";
		}

		$tagname = $this->node_type;

		$contents = is_string( $contents ) ? trim( $contents ) : '';
		$wrapper_tag = "<{$tagname} ".join( ' ', $attrs ).">{$contents}</{$tagname}>";

		return $wrapper_tag;
	}
}
