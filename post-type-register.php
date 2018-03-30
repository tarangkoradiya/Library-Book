<?php 
/*  Register Post Type Book */

add_action( 'init', 'create_book_post' );

function create_book_post() {
    register_post_type( 'book',
        array(
            'labels' => array(
                'name' => 'Books',
                'singular_name' => 'book',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Book',
                'edit' => 'Edit',
                'edit_item' => 'Edit Book',
                'new_item' => 'New Book',
                'view' => 'View',
                'view_item' => 'View Book',
                'search_items' => 'Search Book',
                'not_found' => 'No Book found',
                'not_found_in_trash' => 'No Book found in Trash',
                'parent' => 'Parent Book'
            ),
 
            'public' => true,
            'menu_position' => 15,
            "rewrite" => array( "slug" => "book-list", "with_front" => true ),
            'supports' => array( 'title', 'editor'),
            'menu_icon' => plugins_url( 'images/book.png', __FILE__ ),
            'has_archive' => true
        )
    );
}

/*========  End  Register Post Type Book ====== */

