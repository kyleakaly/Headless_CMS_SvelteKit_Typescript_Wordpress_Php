<?php

/*
    Plugin Name: reinventamos - Faq
    Plugin URI: http://appletoninteractive.ch
    Description: Faq hinzufügen reinventamos
    Version: 1.0.0
    Author: Juan Pablo Appleton
    Author URI: http://appletoninteractive.ch
    Text Domain: reinventamos
*/

if(!defined('ABSPATH')) die();

// Registrar Custom Post Type
function reinventamos_faq_post_type() {

	$labels = array(
		'name'                  => _x( 'Faqsreinventamos', 'Post Type General Name', 'reinventamos' ),
		'singular_name'         => _x( 'Faq', 'Post Type Singular Name', 'reinventamos' ),
		'menu_name'             => __( 'Faqs reinventamos', 'reinventamos' ),
		'name_admin_bar'        => __( 'Faqs', 'reinventamos' ),
		'archives'              => __( 'archives', 'reinventamos' ),
		'attributes'            => __( 'Attribute', 'reinventamos' ),
		'parent_item_colon'     => __( 'Elternklasse', 'reinventamos' ),
		'all_items'             => __( 'alle Faqs', 'reinventamos' ),
		'add_new_item'          => __( 'Faqs hinzufügen', 'reinventamos' ),
		'add_new'               => __( 'Faqs hinzufügen', 'reinventamos' ),
		'new_item'              => __( 'Faqs hinzufügen', 'reinventamos' ),
		'edit_item'             => __( 'Faqs bearbeiten', 'reinventamos' ),
		'update_item'           => __( 'Update-Faqs', 'reinventamos' ),
		'view_item'             => __( 'siehe Faqs', 'reinventamos' ),
		'view_items'            => __( 'siehe Faqs', 'reinventamos' ),
		'search_items'          => __( 'Faqs suchen', 'reinventamos' ),
		'not_found'             => __( 'nicht gefunden', 'reinventamos' ),
		'not_found_in_trash'    => __( 'nicht gefunden in trash', 'reinventamos' ),
		'featured_image'        => __( 'herausragendes Bild', 'reinventamos' ),
		'set_featured_image'    => __( 'Beitragsbild speichern', 'reinventamos' ),
		'remove_featured_image' => __( 'Beitragsbild entfernen', 'reinventamos' ),
		'use_featured_image'    => __( 'als Beitragsbild verwenden', 'reinventamos' ),
		'insert_into_item'      => __( 'Faqs einfügen', 'reinventamos' ),
		'uploaded_to_this_item' => __( 'Faqs hinzufügen', 'reinventamos' ),
		'items_list'            => __( 'Faqsliste', 'reinventamos' ),
		'items_list_navigation' => __( 'Faqsnavigation', 'reinventamos' ),
		'filter_items_list'     => __( 'Faqs filtern', 'reinventamos' ),
	);
	$args = array(
		'label'                 => __( 'Faq', 'reinventamos' ),
		'description'           => __( 'reinventamos-Faq', 'reinventamos'),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => true, // true = posts , false = paginas
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'menu_position'         => 8,
        'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'faq_rein', $args );

}
add_action( 'init', 'reinventamos_faq_post_type', 0 );