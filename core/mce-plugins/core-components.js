(function() {

	/**
	 * The list of component shortcodes.
	 *
	 * @var {object[]}
	 */
	const componentShortcodes = window.themeCore.component_shortcodes;
	if ( ! componentShortcodes ) return;

	/**
	 * Prepares the window body from the specified attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param {object} attributes
	 * @return {object}
	 */
	function prepareWindowBody ( attributes ) {
		const body = [];

		const buildFieldType = {
			string: () => ({
				type: 'textbox'
			}),
			select: options => ({
				type: 'listbox',
				values: Array.isArray( options ) ?
					options.map( ([ value, text ]) => ({ text, value }) ) :
					options
			}),
			target: () => ({
				type: 'checkbox',
				label: 'Open link in a new tab',
				name: 'target'
			}),
			content: () => ({
				type: 'textbox',
				label: 'Content',
				name: 'content',
				multiline: true,
				minWidth: 350,
				minHeight: 120
			})
		};

		for ( let [ attrType, attrLabel, attrOptions ] of attributes ) {
			const field = typeof buildFieldType[ attrType ] !== 'undefined' ?
				buildFieldType[ attrType ]( attrOptions ) :
				null;

			field.coreType = attrType;

			if ( typeof field.label === 'undefined' ) {
				field.label = attrLabel;
			}

			if ( typeof field.name === 'undefined' ) {
				field.name = attrLabel.toLowerCase().replace( /-/g, '_' ).replace( /\s/g, '_' );
			}

			if ( field ) body.push( field );
		}

		return body;
	}

	/**
	 * Inserts a new shortcode with the specified data.
	 *
	 * @since 1.0.0
	 *
	 * @param {object} editor
	 * @param {object} shortcode
	 * @param {object} data
	 */
	function insertShortcode ( editor, shortcode, data ) {
		const { code, body } = shortcode;

		let attributes = [];
		let contents = null;

		for ( let { name, coreType: type } of body ) {
			let value = data[ name ];

			if ( type === 'target' ) value = value ? '_blank' : false;
			if ( typeof value === 'undefined' || ! value ) continue;

			if ( type === 'content' ) {
				contents = value;
				continue;
			}

			attributes.push( `${name}="${value}"` );
		}

		// Build the shortcode string.
		attributes = attributes.join( ' ' );

		const shortcodeStr = contents ?
			`[${code} ${attributes}]${contents.trim()}[/${code}]` :
			`[${code} ${attributes}]`;

		editor.insertContent( shortcodeStr );
	}

	// Register plugin.
	tinymce.create( 'tinymce.plugins.coreComponents', {
		init: ( editor, _url ) => {

			// Register buttons.
			for ( let component of componentShortcodes ) {
				const { shortcode } = component;

				// Prepare the window body from the specified attributes.
				const windowBody = prepareWindowBody( shortcode.attributes );
				shortcode.body = windowBody;

				editor.addButton( shortcode.code, {
					title: shortcode.name,
					icon: `core-icon dashicons-${shortcode.icon}`,
					onclick: () => {
						editor.windowManager.open({
							title: `Add ${shortcode.name}`,
							minWidth: 500,
							body: windowBody,
							onsubmit: ({ data }) => insertShortcode( editor, shortcode, data )
						})
					}
				})
			}
		},
		createControl: () => null
	});

	tinymce.PluginManager.add( 'coreComponents', tinymce.plugins.coreComponents );
})();
