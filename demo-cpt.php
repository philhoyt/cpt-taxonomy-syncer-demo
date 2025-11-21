<?php
/**
 * Plugin Name: Demo CPT for CPT-Taxonomy Syncer
 * Description: Creates demo custom post types "Animals" and "Habitats" with taxonomy "Habitat Types" for testing CPT-Taxonomy Syncer
 * Version: 1.0.0
 * Author: Phil Hoyt
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Animals custom post type
 */
function demo_cpt_register_post_type() {
	register_post_type(
		'animals',
		array(
			'public'       => true,
			'label'        => 'Animals',
			'supports'     => array( 'title', 'editor', 'thumbnail' ),
			'show_in_rest' => true,
			'has_archive'  => true,
		)
	);
}
add_action( 'init', 'demo_cpt_register_post_type' );

/**
 * Register the Habitats custom post type
 */
function demo_cpt_register_habitats_post_type() {
	register_post_type(
		'habitats',
		array(
			'public'       => true,
			'label'        => 'Habitats',
			'supports'     => array( 'title', 'editor', 'thumbnail' ),
			'show_in_rest' => true,
			'has_archive'  => true,
		)
	);
}
add_action( 'init', 'demo_cpt_register_habitats_post_type' );

/**
 * Register the Habitat Types taxonomy (attached to Animals)
 */
function demo_cpt_register_taxonomy() {
	register_taxonomy(
		'habitat_types',
		'animals',
		array(
			'public'       => true,
			'label'        => 'Habitat Types',
			'show_in_rest' => true,
			'hierarchical' => false,
		)
	);
}
add_action( 'init', 'demo_cpt_register_taxonomy' );

/**
 * Show admin notice to configure sync pair
 */
function demo_cpt_admin_notice() {
	// Only show on admin pages
	if ( ! is_admin() ) {
		return;
	}

	// Check if CPT-Taxonomy Syncer is active
	if ( ! function_exists( 'cpt_taxonomy_syncer_init' ) ) {
		return;
	}

	// Check if sync pair is already configured
	$pairs = get_option( 'cpt_tax_syncer_pairs', array() );
	$is_configured = false;
	foreach ( $pairs as $pair ) {
		if ( isset( $pair['cpt_slug'] ) && $pair['cpt_slug'] === 'habitats' 
			&& isset( $pair['taxonomy_slug'] ) && $pair['taxonomy_slug'] === 'habitat_types' ) {
			$is_configured = true;
			break;
		}
	}

	// Don't show notice if already configured
	if ( $is_configured ) {
		return;
	}

	// Show notice
	$settings_url = admin_url( 'tools.php?page=cpt-taxonomy-syncer' );
	?>
	<div class="notice notice-info is-dismissible">
		<p>
			<strong><?php esc_html_e( 'Demo Plugin Ready!', 'cpt-taxonomy-syncer-demo' ); ?></strong>
			<?php
			printf(
				/* translators: %s: Settings page URL */
				esc_html__( 'To enable syncing between the "Habitats" post type and "Habitat Types" taxonomy, please %sconfigure the sync pair%s.', 'cpt-taxonomy-syncer-demo' ),
				'<a href="' . esc_url( $settings_url ) . '">',
				'</a>'
			);
			?>
		</p>
		<p>
			<?php esc_html_e( 'Go to Tools → CPT-Tax Syncer and add a new pair:', 'cpt-taxonomy-syncer-demo' ); ?>
		</p>
		<ul style="list-style: disc; margin-left: 20px;">
			<li><?php esc_html_e( 'Post Type: Habitats', 'cpt-taxonomy-syncer-demo' ); ?></li>
			<li><?php esc_html_e( 'Taxonomy: Habitat Types', 'cpt-taxonomy-syncer-demo' ); ?></li>
		</ul>
	</div>
	<?php
}
add_action( 'admin_notices', 'demo_cpt_admin_notice' );

