<?php
/**
 * Post slide meta box
 *
 * @package WordPress.PostType
 */

namespace WP_Utility;

class Custom_Fields_Meta_Box extends Abstract_Custom_Fields_Meta_Box {

	const NONCE_NAME = 'IMmJes4A38ORC9D';

	public function advanced_meta_textfield( $label, $name, $value ) {
		?>
		<label>
			<p class="label"><?php echo esc_html( $label ); ?></p>
			<?php
			printf(
				'<input type="text" name="%1$s" value="%2$s">',
				esc_attr( $name ),
				esc_attr( $value )
			);
			?>
		</label>
		<?php
	}
}
