<?php
/*
	Plugin Name: Library​ ​Book
	Plugin URI: https://wordpress.org/plugins/library​-book/
	Description: Library​ ​Book​ ​Search.used Search Box Display Shortcode <code>[book_post_search_box]</code>
	Author: Tarang
	Version: 1.0
	Author URI: http://tarang.com
	Text Domain: library​-book
	License: GPLv2
*/



// New post type register file
require_once (dirname(__FILE__).'/post-type-register.php');

// New taxonomy register file
require_once (dirname(__FILE__).'/register_taxonomy.php');

// Book post meta filed create file
require_once (dirname(__FILE__).'/custom_meta_filed.php');

// Frontend display serach filter and all book post file
require_once (dirname(__FILE__).'/search-box-display.php');


// plugin css and script file add 
add_action( 'wp_enqueue_scripts', 'book_scripts' );

function book_scripts(){
	   
	/*
		Search box css
		Price range css
		Star Rating css
	*/
    wp_enqueue_style('style', plugins_url('/css/style.css',__FILE__), array(), '0.1.0', 'all');

    // search box table width set css file
    wp_enqueue_style('grid', plugins_url('/css/grid.css',__FILE__), array(), '0.1.0', 'all');

    wp_enqueue_script( 'jquery-price', plugins_url('/js/jquery-ui.js',__FILE__), array( 'jquery' ), true );

    //price range jquery
    wp_enqueue_script( 'price-slider', plugins_url('/js/price_range.js',__FILE__), array( 'jquery' ), true );

    //search box ajax call
	wp_enqueue_script( 'my_ajax', plugins_url('/js/search_ajax.js',__FILE__), array( 'jquery' ), true );
	wp_localize_script('my_ajax', 'my_ajax_url', array('ajax_url' => admin_url('admin-ajax.php')));
}


add_action('wp_ajax_book_fetch_query' , 'book_fetch_query');
add_action('wp_ajax_nopriv_book_fetch_query','book_fetch_query');


