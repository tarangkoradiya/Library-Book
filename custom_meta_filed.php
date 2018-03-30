<?php 

/*======= Custom Meta Box Create  =========*/

function register__review_meta_boxes() {
	
    add_meta_box( 'book_review_meta_box', __( 'Book Details', 'textdomain' ), 'display_book_meta_box', 'book' );
}
add_action( 'add_meta_boxes', 'register__review_meta_boxes' );
 

function display_book_meta_box( $book ) {


	/*========= Price box display admin site =======*/

	$book_price = intval( get_post_meta( $book->ID, 'book_price', true ) );
   ?>
   <table>
        <tr>
            <td style="width: 150px">Book Price</td>
            <td>
            	<input type="number" name="book_price" value="<?php echo $book_price; ?>">
            </td>
        </tr>
    </table>
   <?php

    /*=========== End  Price box display admin site =========*/
   
    /*=========== Rating box display admin site =============*/

    $book_rating = get_post_meta( $book->ID, 'book_rating');
    ?>
    <table>
        <tr>
            <td style="width: 150px">Book Rating</td>
            <td>
               <select name="book_review_rating">
                <?php
                // Generate all rating of drop-down list
                echo "<option>-- Select Rating --</option>";
                for ( $rating = 5; $rating >= 1; $rating -- ) {
                ?>
                    <option value="<?php echo  $rating; ?>" <?php echo $book_rating[0] == " " ? :selected( $rating, $book_rating[0] ); ?>>
                    <?php echo $rating; ?> Stars </option><?php } ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
    /*=========== End Rating box display admin site =============*/
}

/*=========== Rating and Price insert meta filed =============*/

add_action( 'save_post', 'add_book_fields', 10, 2 );
function add_book_fields( $book_id, $book ) {

    // Check post type for book
    if ( $book->post_type == 'book' ) {
    	
        // Store data in post meta table if present in post data
        if ( isset( $_POST['book_price'] ) && $_POST['book_price'] != '' ) {
            update_post_meta( $book_id, 'book_price', $_POST['book_price'] );
        
        }
        if ( isset( $_POST['book_review_rating'] ) && $_POST['book_review_rating'] != '' ) {
            update_post_meta( $book_id, 'book_rating', $_POST['book_review_rating'] );

        }
    }
}
/*=========== End Rating and Price insert meta filed =============*/


/*=========== New Book Post create and auto add meta valuse =============*/

add_action('save_post_book', 'add_custom_field_automatically');
function add_custom_field_automatically($post_ID) {
    global $wpdb;
    if(!wp_is_post_revision($post_ID)) {
        add_post_meta($post_ID, 'book_price', '1', true);
        add_post_meta($post_ID, 'book_rating', '1', true);
    }
}
/*=========== New Book Post create and auto add meta valuse =============*/


/*====== End Custom Meta Box Create =======*/