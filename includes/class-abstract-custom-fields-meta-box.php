<?php
/**
 * Abstract Metabox
 *
 * @package WordPress.PostType
 */

namespace WP_Utility;

abstract class Abstract_Custom_Fields_Meta_Box {

	const NONCE_NAME = 'xYgneuTPt75rMvk';

	private $fields = array();
	private $args;
	private $nonce;

	public function __construct( $fields, $args = array() ) {
		$this->fields = $fields;
		$this->args   = wp_parse_args(
			$args,
			array(
				'title'         => __( 'Доп. данные' ),
				'context'       => 'side',
				'priority'      => 'default',
				'callback_args' => null,
			)
		);
	}

	public function init( $post_type ) {
		if ( ! is_string( $post_type ) ) {
			return new \Exception( 'Post type must be string' );
		}

		add_action(
			'add_meta_boxes',
			function() use ( $post_type ) {
				add_meta_box(
					"{$post_type}_advanced_meta",
					$this->args['title'],
					array( $this, 'metabox_html' ),
					$post_type,
					$this->args['context'],
					$this->args['priority'],
					$this->args['callback_args']
				);
			}
		);

		add_action( 'save_post', array( $this, 'save' ) );
	}

	abstract public function advanced_meta_textfield( $label, $name, $value );

	public function get_meta_values( &$label, $name, $post_id ) {
		$label = get_post_meta( $post_id, $name, true );
	}

	public function nonce_field() {
		wp_nonce_field( basename( __FILE__ ), static::NONCE_NAME );
	}

	public function metabox_html( $post ) {
		$meta_values = $this->fields;
		array_walk( $meta_values, array( $this, 'get_meta_values' ), $post->ID );

		// Nonce security.
		$this->nonce_field();

		array_map(
			array( $this, 'advanced_meta_textfield' ),
			$this->fields,
			array_keys( $this->fields ),
			$meta_values
		);
	}

	/**
	 * Update custom field by post ID
	 */
	public function update_single_post_meta( $label, $name, $post_id ) {
		if ( ! isset( $_POST[ static::NONCE_NAME ] ) ) {
			return $post_id;
		}

		$nonce = sanitize_text_field( wp_unslash( $_POST[ static::NONCE_NAME ] ) );

		// Stop on fail check security.
		if ( ! wp_verify_nonce( $nonce, basename( __FILE__ ) ) ) {
			return $post_id;
		}

		$_name = esc_attr( $name );

		if ( isset( $_POST[ $_name ] ) ) {
			update_post_meta( $post_id, $name, sanitize_text_field( wp_unslash( $_POST[ $_name ] ) ) );
		}
	}

	/**
	 * Update custom fields on Post save
	 */
	public function save( $post_id ) {
		// Stop on autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Stop on user can't edit this post.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Update fields.
		array_walk( $this->fields, array( $this, 'update_single_post_meta' ), $post_id );

		return $post_id;
	}
}
