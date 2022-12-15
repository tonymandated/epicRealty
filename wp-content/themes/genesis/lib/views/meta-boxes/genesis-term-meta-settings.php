<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package StudioPress\Genesis
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://my.studiopress.com/themes/genesis/
 */

$genesis_tax = get_taxonomy( $object->taxonomy );
?>
<h2><?php echo esc_html( $genesis_tax->labels->singular_name ) . ' ' . esc_html__( 'Archive Settings', 'genesis' ); ?></h2>
<table class="form-table">
	<tbody>
		<tr class="form-field">
			<th scope="row"><label for="genesis-meta[headline]"><?php esc_html_e( 'Archive Headline', 'genesis' ); ?></label></th>
			<td>
				<input name="genesis-meta[headline]" id="genesis-meta[headline]" type="text" value="<?php echo esc_attr( get_term_meta( $object->term_id, 'headline', true ) ); ?>" size="40" />
				<p class="description">
					<?php
					if ( genesis_a11y( 'headings' ) ) {
						esc_html_e( 'Your child theme uses accessible headings. If you leave this blank, the default accessible heading will be used.', 'genesis' );
					} else {
						esc_html_e( 'Leave empty if you do not want to display a headline.', 'genesis' );
					}
					?>
				</p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="genesis-meta-intro-text"><?php esc_html_e( 'Archive Intro Text', 'genesis' ); ?></label></th>
			<td>
				<?php
				wp_editor(
					get_term_meta( $object->term_id, 'intro_text', true ),
					'genesis-meta-intro-text',
					[
						'textarea_name' => 'genesis-meta[intro_text]',
					]
				);
				?>
				<p class="description"><?php esc_html_e( 'Leave empty if you do not want to display any intro text.', 'genesis' ); ?></p>
			</td>
		</tr>
	</tbody>
</table>
