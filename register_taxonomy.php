<?php 


/* ======= Register Taxonomy Author ========*/

function register_taxonomy_author() {

    /**
     * Taxonomy: Author.
     */

    $labels = array(
        "name" => __( "Author"),
        "singular_name" => __( "author" ),
    );

    $args = array(
        "label" => __( "Author"),
        "labels" => $labels,
        "public" => true,
        "hierarchical" => true,
        "label" => "Author",
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => array( 'slug' => 'book_author', 'with_front' => true, ),
        "show_admin_column" => false,
        "show_in_rest" => false,
        "rest_base" => "",
        "show_in_quick_edit" => false,
    );
    register_taxonomy( "book_author", array( "book" ), $args );
}

add_action( 'init', 'register_taxonomy_author' );


/*======== End Register Taxonomy Author =========*/


/*========  Register Taxonomy Publisher =========*/

function register_taxonomy_publisher() {
/**
     * Taxonomy: Publisher.
     */

    $labels = array(
        "name" => __( "Publisher"),
        "singular_name" => __( "publisher" ),
    );

    $args = array(
        "label" => __( "Publisher"),
        "labels" => $labels,
        "public" => true,
        "hierarchical" => true,
        "label" => "Publisher",
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => array( 'slug' => 'book_publisher', 'with_front' => true, ),
        "show_admin_column" => false,
        "show_in_rest" => false,
        "rest_base" => "",
        "show_in_quick_edit" => false,
    );
    register_taxonomy( "book_publisher", array( "book" ), $args );
}

add_action( 'init', 'register_taxonomy_publisher' );


/*======== End Register Taxonomy Publisher =========*/

