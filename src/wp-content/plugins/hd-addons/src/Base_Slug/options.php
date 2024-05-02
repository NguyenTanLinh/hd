<?php

$custom_base_slug_options = get_option( 'custom_base_slug__options' );
$base_slug_post_type      = $custom_base_slug_options['base_slug_post_type'] ?? [];
$base_slug_taxonomy       = $custom_base_slug_options['base_slug_taxonomy'] ?? [];

?>
<h2><?php _e( 'Remove Base Slug', ADDONS_TEXT_DOMAIN ); ?></h2>

<div class="section section-checkbox" id="section_base_slug_post_type">
	<span class="heading block !fw-700"><?php _e( 'Post Types', ADDONS_TEXT_DOMAIN ); ?></span>
	<?php

	$post_types = get_post_types(
		[
			'show_ui'  => true,
			'public'   => true,
			'_builtin' => false,
		],
		'objects'
	);

	foreach ( $post_types as $post_type ) :
		if ( $post_type->name == 'attachment' ) {
			continue;
		}

		$label = $post_type->label;
		$label .= ' <span class="!fw-400">(' . $post_type->name . ')</span>';
	?>
	<div class="option mb-20">
        <label class="controls">
            <input type="checkbox" class="hd-checkbox hd-control" name="base_slug_post_type[]" value="<?php echo esc_attr_strip_tags( $post_type->name ); ?>" <?php in_array_checked( $base_slug_post_type, $post_type->name ); ?>>
        </label>
        <div class="explain"><?php echo $label; ?></div>
    </div>
	<?php endforeach; ?>
</div>

<div class="section section-checkbox" id="section_base_slug_taxonomy">
	<span class="heading block !fw-700"><?php _e( 'Taxonomies', ADDONS_TEXT_DOMAIN ); ?></span>
	<?php

	$taxonomies = get_taxonomies(
		[
			'show_ui' => true,
			'public'  => true,
		],
		'objects'
	);

	foreach ( $taxonomies as $taxonomy ) :
		$label = $taxonomy->label;
		$label .= ' <span class="!fw-400">(' . $taxonomy->name . ')</span>';
	?>
	<div class="option mb-20">
        <label class="controls">
            <input type="checkbox" class="hd-checkbox hd-control" name="base_slug_taxonomy[]" value="<?php echo esc_attr_strip_tags( $taxonomy->name ); ?>" <?php in_array_checked( $base_slug_taxonomy, $taxonomy->name ); ?>>
        </label>
        <div class="explain"><?php echo $label; ?></div>
    </div>
	<?php endforeach; ?>
</div>

<div class="section section-checkbox" id="section_base_slug_reset">
	<span class="heading block !fw-700"><?php _e( 'Reset', ADDONS_TEXT_DOMAIN ); ?></span>
	<div class="option mb-20">
		<label class="controls">
			<input type="checkbox" class="hd-checkbox hd-control" name="base_slug_reset" id="base_slug_reset" value="1">
		</label>
		<div class="explain"><?php _e( 'Reset all', ADDONS_TEXT_DOMAIN ); ?></div>
	</div>
</div>
