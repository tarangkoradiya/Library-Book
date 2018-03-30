
jQuery( function() {
        jQuery( "#slider-range" ).slider({
            range: true,
            min: 1,
            max: 3000,
            values: [ 1, 3000 ],
            slide: function( event, ui ) {
                jQuery( "#book_price_min" ).val(ui.values[ 0 ]);
                jQuery( "#book_price_max" ).val(ui.values[ 1 ]);
                jQuery( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );

            }
        });
        jQuery( "#book_price_min" ).val(1);
        jQuery( "#book_price_max" ).val(3000);
        jQuery( "#amount" ).val( "$" + jQuery( "#slider-range" ).slider( "values", 0 ) +
            " - $" + jQuery( "#slider-range" ).slider( "values", 1 ) );
    } );