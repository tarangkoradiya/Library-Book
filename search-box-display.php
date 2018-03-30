<?php

/* 
    Shortcode create action
    Search box show Frontend used shortcode
 */
add_shortcode('book_post_search_box', 'post_search_box');

function post_search_box() {
?>


<!--=========== Search Box Show Frontend ============-->

<div class="book-wrapper">
    <div class="book_search_box">
        <div class="book_search_box-title">
            <h3>Book Search</h3>
        </div>
        <div class="grid_col grid_col--1-of-2">
            <div class="grid_col grid_col--1-of-4 grid_col--lc-1-of-1 grid_col--md-1-of-1 grid_col--sm-1-of-1">
                <label>Book name: </label>
            </div>
            <div class="grid_col grid_col--3-of-4 grid_col--lc-1-of-1 grid_col--md-1-of-1 grid_col--sm-1-of-1">
                <input type="text" name="book_name" id="book_name">
            </div>  
        </div>

        <div class="grid_col grid_col--1-of-2">
            <div class="grid_col grid_col--1-of-4">
            <label>Author: </label>
            </div>
            <div class="grid_col grid_col--3-of-4">
                <input type="text" name="book_author" id="book_author">
            </div>
        </div>
        
        <div class="grid_col grid_col--1-of-2">
            <div class="grid_col grid_col--1-of-4">
            <label>Publisher: </label>
            </div>
            <div class="grid_col grid_col--3-of-4">
                <?php 
                $taxonomy = 'book_publisher';
                $terms = get_terms($taxonomy); // Get  terms of a taxonomy
                ?>
                <select name="book_publisher" id="book_publisher">
                        <option value="">- Publisher -</option>
                    <?php foreach ( $terms as $term ) { ?>
                        <option value="<?php echo $term->name; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="grid_col grid_col--1-of-2">
            <div class="grid_col grid_col--1-of-4">
            <label>Rating: </label>
            </div>
            <div class="grid_col grid_col--2-of-5">
                <select name="book_rating" id="book_rating">
                    <option value="">- Ratings -</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="grid_col grid_col--1-of-5">
                <p>values 1 to 5</p>
            </div>
        </div>

        <div class="grid_col grid_col--1-of-2">
            <div class="grid_col grid_col--1-of-4">
            <label>Price: </label>
            </div>
            <div class="grid_col grid_col--3-of-4">
                <div id="price"></div>
                    <input type="text" name="book-price-min" id="book_price_min" value="">
                    <input type="hidden" name="book-price-max" id="book_price_max" value="">
                  
                    <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                    <div id="slider-range"></div>
            </div>
        </div>

        <div class="book_search_box-button">
            <!-- onclick function call ajax book_data_fetch -->
            <button class="button" onclick="book_data_fetch()">Serach</button>
        </div>
     </div>
</div>

<!--= ajax data return html   ===-->
<div id="all_book_datafetch">Search results will appear here</div>


<!--=========== End Search Box Show Frontend ============-->

<script type="text/javascript">

     jQuery(document).ready(function() { // Page load and all post show
        book_data_fetch();
     });
    jQuery(document).on("click",".page-numbers",function(){ // Post Pagination click

        var nav_number = jQuery(this).attr("href").match(/paged=([0-9]+)/)[1];
        book_data_fetch(nav_number);
        return false;
    });
</script>

<?php	
}
// End function post_search_box()


function book_fetch_query(){

if (isset($_POST['page_number'])) { $paged  = $_POST['page_number']; } else { $paged=1; };

    $the_query = new WP_Query( array( 
    	'posts_per_page' => 5, 
        'paged' => get_query_var('paged') ? get_query_var('paged') : $paged,
    	's' => esc_attr( $_POST['book_name'] ),
    	'post_type' => 'book',
    	'tax_query' => array(
            array(
                'taxonomy' => 'book_publisher',
                'field'    => 'name',
                'terms'    => esc_attr( $_POST['book_publisher'] ),
                'operator' => $_POST['book_publisher'] ? 'IN' : 'NOT IN',
            ),
            array(
                'taxonomy' => 'book_author',
                'field'    => 'name',
                'terms'    => esc_attr( $_POST['book_author'] ),
                'operator' => $_POST['book_author'] ? 'IN' : 'NOT IN',
            ),
        ),
    	'meta_query' => array(
			array(
	          'key'		=> 'book_price',
	          'value'	=> array($_POST['book_price_min'], $_POST['book_price_max']),
	          'type' => 'numeric',
			  'compare' => 'BETWEEN'
			),
            array(
              'key'     => 'book_rating',
              'value'   => esc_attr($_POST['book_rating']),
              'type' => 'numeric',
              'compare' => $_POST['book_rating'] ? '=' : '!=',

            ),
		),

    ) );
    ?>

 <!-- Search results display html -->   
<div class="search_results">
    <div class="search_results-title grid_col grid_col--1-of-1">
        <div class="grid_col grid_col--1-of-12">
            <h4>No</h4>
        </div>
        <div class="grid_col grid_col--1-of-3">
            <h4>Book Name</h4>
        </div>
        <div class="grid_col grid_col--1-of-12">
            <h4>Price</h4>
        </div>
        <div class="grid_col grid_col--1-of-6">
            <h4>Author</h4>
        </div>
        <div class="grid_col grid_col--1-of-6">
            <h4>Publisher</h4>
        </div>
        <div class="grid_col grid_col--1-of-6">
            <h4>Rating</h4>
        </div>
    </div>
    <hr>
     
    <?php
        if( $the_query->have_posts() ) :

            $start_index = ($paged-1) * 5;
            $start_index == 0 ? $start_index = 1 : $start_index++;
            while( $the_query->have_posts() ): $the_query->the_post(); ?>

                <div class="search_results-data grid_col grid_col--1-of-1">
                    <div class="grid_col grid_col--1-of-12">
                        <?php   echo $start_index++; ?>
                    </div>
                    <div class="grid_col grid_col--1-of-3">
                        <!-- book title Display -->
                        <a href="<?php echo esc_url( post_permalink() ); ?>"><?php the_title();?></a>
                    </div>
                    <div class="grid_col grid_col--1-of-12">
                        <?php                        
                        //=============== Price Display ==================

                            $price = get_post_meta( get_the_ID(), 'book_price'); 
                            echo  "$".$price[0];

                        //===============End Price Display ================== 
                        ?>
                    </div>
                    <div class="grid_col grid_col--1-of-6">
                        <?php 
                        //================  Author Display =====================
                            $url = site_url();
                            $terms_author = get_the_terms( get_the_ID(), 'book_author' );
                           
                            if ($terms_author) {
                                $author_count = count($terms_author);                      
                                foreach($terms_author as $term_author) {
                                    echo "<a href='" . $url . "/book_author/" . $term_author->slug . "'>" .$term_author->name."</a>";
                                    if($author_count != 1) {
                                        echo ", ";
                                    }

                                } 
                            }    
                            //================  End Author Display =====================
                        ?>
                    
                    </div>
                    <div class="grid_col grid_col--1-of-6">
                        <?php 
                        //================  Publisher Display =====================
                            $terms_publisher = get_the_terms( get_the_ID(), 'book_publisher' );
                                                   
                            if ($terms_publisher) {
                                 $publisher_count = count($terms_publisher); 
                                foreach($terms_publisher as $term_publisher) {
                                    echo "<a href='" . $url . "/book_publisher/" . $term_publisher->slug . "'>" .$term_publisher->name."</a>";
                                    if($publisher_count != 1) {
                                        echo ", ";
                                    }
                                } 
                            }    
                        //================  End Publisher Display =====================
                        ?>
                   
                    </div>
                    <div class="grid_col grid_col--1-of-6">
                        <?php
                        //================  Rating Display =====================

                            $book_rating = get_post_meta( get_the_ID(), 'book_rating');
                            $average_star = array(
                            'rating' => $book_rating[0],
                            'type' => 'rating',
                            );
                            wp_star_rating( $average_star );

                        //================  End Rating Display =====================
                        ?>
                    </div>
                </div>

            <?php
            endwhile;
                wp_reset_postdata();  
                ?>

                <div class="book_paginate grid_col grid_col--1-of-1">
                    <?php
                    /*========== Pagination display =======*/ 
                    $big_pagination = 999999999; // 
                    echo paginate_links( array(
                        'base' => str_replace( $big_pagination, '%#%', get_pagenum_link( $big_pagination ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, $paged ),
                        'total' => $the_query->max_num_pages
                    ) );
                     /*========== End Pagination display =======*/
                    ?>
                    
                </div>
                <?php
             
        else:
            echo "<h2><em>No Results were found.</em></h2>";
        endif;   
        wp_die();
    ?>
</div>
    <?php
}
?>
