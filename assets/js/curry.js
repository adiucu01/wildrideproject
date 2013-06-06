/*!
 * Curry currency conversion jQuery Plugin v0.6
 * https://bitbucket.org/netyou/curry-currency-ddm
 *
 * Copyright 2013, Yotam Praag
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.opensource.org/licenses/GPL-2.0
 */
(function( $ ){

	$.fn.curry = function( options ){
	
		var output = '',
			rates = {},
			t = this,
            requestedCurrency = false,
            dropDownMenu,
            item, keyName,
			i, l, rate;
			
		// Create some defaults, extending them with any options that were provided
		var settings = $.extend( {
			target: '.price',
			change: true,
			base: 'USD',
			symbols: {}
		}, options);

        this.each(function(){
            
            var $this = $(this),
                tempHolder;

            // keep any classes attached to the original element
            output = '<select class="curry-ddm '+ $this.attr('class') +'">';
            output += '</select>';
        
            // Replace element with generated select
            tempHolder = $( output ).insertAfter( $this );
            $this.detach();
            
            // Add new drop down to jquery list (jquery object)
            dropDownMenu = !dropDownMenu ? tempHolder : dropDownMenu.add( tempHolder );
        
        });
        
        // Create the html for the drop down menu
		var generateDDM = function( rates ){
        
            output = '';
		
			// Change all target elements to drop downs
			dropDownMenu.each(function(){
				
				for ( i in rates ) {
				
					rate = rates[i];
					
					output += '<option value="'+ i +'" data-rate="'+ rate +'">' + i + '</option>';
				
				}
                
                $( output ).appendTo( this );
				
			});
		
		};
		
		if ( !settings.customCurrency ) {
        
            // Only get currency hash once
            if ( !requestedCurrency ) {
            
                // Request currencies from yahoo finance
                var jqxhr = $.ajax({ 
                    url: 'http://query.yahooapis.com/v1/public/yql',
                    dataType: 'jsonp',
                    data: {
                        q :         'select * from yahoo.finance.xchange where pair="USDINR,USDEUR,USDCAD,USDGBP,USDILS"',
                        format :    'json',
                        env :       'store://datatables.org/alltableswithkeys'
                    }
                });
                
                jqxhr.success(function( data ){

                    var items = data.query.results.rate;

                    // Add the base currency to the rates
                    rates[ settings.base ] = 1;
                    
                    for ( var i=0, l=items.length; i<l; i++ ){

                        item = items[i];
                        keyName = item.Name.substr( item.Name.length - 3 );
                    
                        rates[ keyName ] = +item.Rate;

                    }
                    
                    generateDDM( rates );
                    
                    // Set flag so we know we received currencies
                    requestedCurrency = true;
                    
                });
            
            }

		} else {
		
			generateDDM( settings.customCurrency );
		
		}

        // only change target when change is set by user
		if ( settings.change ) {
		
                // Add default currency symbols
			var symbols = $.extend({
                    'USD' : '&#36;',
                    'GBP' : '&pound;',
                    'EUR' : '&euro;',
                    'JPY' : '&yen;'
                }, settings.symbols ),
                $priceTag, symbol;
            
			$(document).on( 'change', this.selector, function(){
			
				var $target = $( settings.target ),
					$option = $(this).find(':selected'),
					rate = $option.data('rate'),
					money, result, l = $target.length;
                    
                for ( var i=0 ; i < l; i++ ){

                    $price = $( $target[i] );
                    money = $price.text();
                    money = Number( money.replace(/[^0-9\.]+/g,"") );

                    if ( $price.data('base-figure') ){

                        // If the client changed the currency there should be a base stored on the element
                        result = rate * $price.data('base-figure');

                    } else {
                        
                        // Store the base price on the element
                        $price.data('base-figure', money);
                        result = rate * money;

                    }

                    // Parse as two decimal number
                    result = Number( result.toString().match(/^\d+(?:\.\d{0,2})?/) );
                    
                    symbol = symbols[ $option.val() ] || $option.val();
                    
                    $price.html( '<span class="symbol">' + symbol + '</span>' + result );
                
                }
				
			});
			
		}
        
		// Returns jQuery object for chaining
		return dropDownMenu;
	
	};

})( jQuery );