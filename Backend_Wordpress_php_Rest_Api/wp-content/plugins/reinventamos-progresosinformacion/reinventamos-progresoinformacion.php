<?php

/*
    Plugin Name: reinventamos - Prozesse
    Plugin URI: http://appletoninteractive.ch
    Description: Prozesse hinzufügen reinventamos
    Version: 1.0.0
    Author: Juan Pablo Appleton
    Author URI: http://appletoninteractive.ch
    Text Domain: reinventamos
*/

if(!defined('ABSPATH')) die();

// Registrar Custom Post Type
function reinventamos_Prozesse_post_type() {

	$labels = array(
		'name'                  => _x( 'Prozessereinventamos', 'Post Type General Name', 'reinventamos' ),
		'singular_name'         => _x( 'Prozess', 'Post Type Singular Name', 'reinventamos' ),
		'menu_name'             => __( 'Prozesse reinventamos', 'reinventamos' ),
		'name_admin_bar'        => __( 'Prozesse', 'reinventamos' ),
		'archives'              => __( 'archives', 'reinventamos' ),
		'attributes'            => __( 'Attribute', 'reinventamos' ),
		'parent_item_colon'     => __( 'Elternklasse', 'reinventamos' ),
		'all_items'             => __( 'alle Prozesse', 'reinventamos' ),
		'add_new_item'          => __( 'Prozesse hinzufügen', 'reinventamos' ),
		'add_new'               => __( 'Prozesse hinzufügen', 'reinventamos' ),
		'new_item'              => __( 'Prozesse hinzufügen', 'reinventamos' ),
		'edit_item'             => __( 'Prozesse bearbeiten', 'reinventamos' ),
		'update_item'           => __( 'Update-Prozesse', 'reinventamos' ),
		'view_item'             => __( 'siehe Prozesse', 'reinventamos' ),
		'view_items'            => __( 'siehe Prozesse', 'reinventamos' ),
		'search_items'          => __( 'Prozesse suchen', 'reinventamos' ),
		'not_found'             => __( 'nicht gefunden', 'reinventamos' ),
		'not_found_in_trash'    => __( 'nicht gefunden in trash', 'reinventamos' ),
		'featured_image'        => __( 'herausragendes Bild', 'reinventamos' ),
		'set_featured_image'    => __( 'Beitragsbild speichern', 'reinventamos' ),
		'remove_featured_image' => __( 'Beitragsbild entfernen', 'reinventamos' ),
		'use_featured_image'    => __( 'als Beitragsbild verwenden', 'reinventamos' ),
		'insert_into_item'      => __( 'Prozesse einfügen', 'reinventamos' ),
		'uploaded_to_this_item' => __( 'Prozesse hinzufügen', 'reinventamos' ),
		'items_list'            => __( 'Prozesse', 'reinventamos' ),
		'items_list_navigation' => __( 'Prozesse', 'reinventamos' ),
		'filter_items_list'     => __( 'Prozesse filtern', 'reinventamos' ),
	);
	$args = array(
		'label'                 => __( 'Prozesse', 'reinventamos' ),
		'description'           => __( 'reinventamos-Prozesse', 'reinventamos'),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => true, // true = posts , false = paginas
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'menu_position'         => 7,
        'menu_icon'             => 'dashicons-screenoptions',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'prozess_rein', $args);

}
add_action( 'init', 'reinventamos_Prozesse_post_type', 0 );