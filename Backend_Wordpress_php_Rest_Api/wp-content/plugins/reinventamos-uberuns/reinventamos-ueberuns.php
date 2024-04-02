<?php

/*
    Plugin Name: reinventamos - Ueber uns
    Plugin URI: http://appletoninteractive.ch
    Description: Ueber hinzufügen reinventamos
    Version: 1.0.0
    Author: Juan Pablo Appleton
    Author URI: http://appletoninteractive.ch
    Text Domain: reinventamos
*/

if(!defined('ABSPATH')) die();

// Registrar Custom Post Type
function reinventamos_Ueberuns_post_type() {

	$labels = array(
		'name'                  => _x( 'Ueberunreinventamos', 'Post Type General Name', 'reinventamos' ),
		'singular_name'         => _x( 'Ueberun', 'Post Type Singular Name', 'reinventamos' ),
		'menu_name'             => __( 'Ueberuns reinventamos', 'reinventamos' ),
		'name_admin_bar'        => __( 'Ueberuns', 'reinventamos' ),
		'archives'              => __( 'archives', 'reinventamos' ),
		'attributes'            => __( 'Attribute', 'reinventamos' ),
		'parent_item_colon'     => __( 'Elternklasse', 'reinventamos' ),
		'all_items'             => __( 'alle Ueberuns', 'reinventamos' ),
		'add_new_item'          => __( 'Ueberuns hinzufügen', 'reinventamos' ),
		'add_new'               => __( 'Ueberuns hinzufügen', 'reinventamos' ),
		'new_item'              => __( 'Ueberuns hinzufügen', 'reinventamos' ),
		'edit_item'             => __( 'Ueberuns bearbeiten', 'reinventamos' ),
		'update_item'           => __( 'Update-Ueberuns', 'reinventamos' ),
		'view_item'             => __( 'siehe Ueberuns', 'reinventamos' ),
		'view_items'            => __( 'siehe Ueberuns', 'reinventamos' ),
		'search_items'          => __( 'Ueberuns suchen', 'reinventamos' ),
		'not_found'             => __( 'nicht gefunden', 'reinventamos' ),
		'not_found_in_trash'    => __( 'nicht gefunden in trash', 'reinventamos' ),
		'featured_image'        => __( 'herausragendes Bild', 'reinventamos' ),
		'set_featured_image'    => __( 'Beitragsbild speichern', 'reinventamos' ),
		'remove_featured_image' => __( 'Beitragsbild entfernen', 'reinventamos' ),
		'use_featured_image'    => __( 'als Beitragsbild verwenden', 'reinventamos' ),
		'insert_into_item'      => __( 'Ueberuns einfügen', 'reinventamos' ),
		'uploaded_to_this_item' => __( 'Ueberuns hinzufügen', 'reinventamos' ),
		'items_list'            => __( 'Ueberunsliste', 'reinventamos' ),
		'items_list_navigation' => __( 'Ueberunsnavigation', 'reinventamos' ),
		'filter_items_list'     => __( 'Ueberuns filtern', 'reinventamos' ),
	);
	$args = array(
		'label'                 => __( 'Ueberuns', 'reinventamos' ),
		'description'           => __( 'reinventamos-Ueberuns', 'reinventamos'),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => true, // true = posts , false = paginas
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'menu_position'         => 9,
        'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'ueberuns_rein', $args );

}
add_action( 'init', 'reinventamos_Ueberuns_post_type', 0 );