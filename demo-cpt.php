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

