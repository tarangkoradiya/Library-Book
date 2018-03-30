function book_data_fetch(nav_number){

    jQuery.ajax({
        url: my_ajax_url.ajax_url,
        type: 'post',
        data: {     
                    // function call search-box-display.php file
        			action: 'book_fetch_query',

                    // book name filed valuse get 
        			book_name: jQuery('#book_name').val(),

                    // book_author filed valuse get 
        			book_author: jQuery('#book_author').val(),

                    // book_publisher filed valuse get 
        			book_publisher: jQuery('#book_publisher').val(),

                    // book_price_max filed valuse get 
        			book_price_max: jQuery('#book_price_max').val(),

                    // book_price-min filed valuse get 
        			book_price_min: jQuery('#book_price_min').val(),

                    // book_rating filed valuse get 
                    book_rating: jQuery('#book_rating').val(),

                    // pagination number valuse get 
                    page_number: nav_number,

        	  },
        success: function(data) {
            // data values passed this id 
            jQuery('#all_book_datafetch').html( data );
        }
    });

}