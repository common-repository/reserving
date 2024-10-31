
  let quantities = {};
  jQuery(document).on(
    "input",
    ".woocommerce-cart-form .extra_quantity",
    function () {
    
      let cart_ids = jQuery(".woocommerce-cart-form .reserving_extra_items")
        .map(function () {
          return jQuery(this).data("cart-id");
        })
        .get();
     
      cart_ids.forEach(function (cart_id) {

        let item_quanitites = jQuery(
          ".woocommerce-cart-form .reserving_extra_items[data-cart-id='" +
            cart_id +
            "'] .extra_quantity"
        );

        quantities[cart_id] = [];

        jQuery(item_quanitites).each(function () {
          quantities[cart_id].push(jQuery(this).val());
        });
      });
  
      document.cookie = "reserving_extra_quantities=" + JSON.stringify(quantities);
    }
  );


  
  jQuery(document).on("updated_cart_totals", function (e) {
   reserving_update_side_cart('updated_cart_totals');
 });
 
  jQuery(document).on("wc_fragments_refreshed", function (e,data) {
     
  });

  jQuery(document).on("wc_cart_emptied", function (e) {
    jQuery('.element-ready-shopping_cart-list-items').html('');
    jQuery('.element-ready-sub-total-amount').html('');
    jQuery('.element-ready-interface-cart-count').text(0);
  });


  //$( document.body ).trigger( 'adding_to_cart', [ $thisbutton, data ] );
  // $( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $thisbutton ] );
  // $( document.body ).trigger( 'removed_from_cart', [ response.fragments, response.cart_hash, $thisbutton ] );
  // $( document.body ).trigger( 'wc_cart_button_updated', [ $button ] );
  // $( document.body ).trigger( 'cart_page_refreshed' );
  // $( document.body ).trigger( 'cart_totals_refreshed' );
  // $( document.body ).trigger( 'wc_fragments_loaded' );

  // thankyou [page][audio effect]
  document.addEventListener('DOMContentLoaded', function(){
      
      /** Thankyou | Order received */
      
      if(jQuery('#reserving_thankyou_audio').length){
        var audio_src    = jQuery('#reserving_thankyou_audio').attr('src');
        var reserving_audio = new Audio(audio_src);
        if (typeof reserving_audio.play !== "undefined") { 
          reserving_audio.play();
        }
      }
     
      /** Cart Extra charge | Tip */
      //reserving_validate_tip_amount();

      // Input input onpaste keyup
      jQuery(document).on(
        "input",
        ".reserving--tip-fixed-input--wrapper input",
        function (e) {
          reserving_validate_tip_amount();
      });

      jQuery(document).on(
        "change",
        ".reserving--tip--type .reserving--cart--tip--type",
        function (e) {
          reserving_cart_tip_input_clear();
      });
      
        // Checkout Store
        jQuery(document).on(
          "click",
          ".reserving--tip--action .reserving_extra_tip",
          function (e) {
            e.preventDefault();
            reserving_checkout_tip_store(e);
            reserving_cart_tip_input_clear();
        });

      // Tip Remove button | Checkout Page only  
      jQuery(document).on(
        "click",
        ".reserving--tip--action .reserving--cart--remove--extra-tip",
        function (e) {
    
          e.preventDefault();
            reserving_cart_tip_input_clear();
            var data = {
              'action'                : 'reserving_cart_tip_remove',
              'reserving_cart_tip_amount': 0
            };
          
            jQuery.get(reserving_update_cart_vars.ajaxurl, data, function(response) {
              
              jQuery(document.body).trigger("update_checkout");

              var update_cart = document.querySelector(".actions button[name*='update_cart']");
              // Cart submit
              if( update_cart ){
                  update_cart.disabled = false; 
                  update_cart.click(); 
              }
              
            });
    

        });
    

  } , false);

  function reserving_validate_tip_amount(){

    var tips_button_add    = document.querySelector('.reserving--tip--action .reserving_extra_tip');
    var tips_button_remove = document.querySelector('.reserving--tip--action .reserving--cart--remove--extra-tip');
    var input              = document.querySelector('.reserving--tip-fixed-input--wrapper input');
    
    if(!tips_button_add){
      return;
    }
  
    var cart_tip_amount = Number( input.value );

    if(cart_tip_amount > 0){
      tips_button_add.disabled = false;
      tips_button_remove.disabled = false;
    }else{
    
      tips_button_add.disabled = true;
      tips_button_remove.disabled = true;
    }
  }

  function reserving_cart_tip_input_clear(){
    var input = document.querySelector('.reserving--tip-fixed-input--wrapper input');
    input.value = '';
    input.focus();
  }

  function reserving_checkout_tip_store(event){

    var cart_tip_amount = Number( document.querySelector('.reserving--tip-fixed-input--wrapper input').value );
    var cart_tip_type = document.querySelector('.reserving--tip--type select').value;
    var update_cart = document.querySelector(".actions button[name*='update_cart']");
    if(cart_tip_amount < 0){
      return;
    }

    var data = {
      'action'                : 'reserving_cart_tip_update',
      'reserving_cart_tip_type'  : cart_tip_type,
      'reserving_cart_tip_amount': cart_tip_amount
    };
  
    jQuery.get(reserving_update_cart_vars.ajaxurl, data, function(response) {
    
      jQuery(document.body).trigger("update_checkout");
      
      // Cart submit
      if(update_cart){
        update_cart.disabled = false; 
        update_cart.click(); 
      }

    });
  
  }

  // Update sidebar

  function reserving_update_side_cart(event_type = ''){
    var data = {
      'action' : 'reserving_cart_latest_content',
    };

    jQuery.get(reserving_update_cart_vars.ajaxurl, data, function(response) {
      var data = null;  
      var $html_cart_item = jQuery('.element-ready-shopping_cart-list-items ul').html('');  
      if(response.success){
        data = response.data.line_items;
        jQuery('.element-ready-wc-shopping-total-amount').text(response.data.subtotal);
        
        jQuery.each(data, function( index, item ) {
         
           var item_html = `
           <li data-key="${index}">
              <div class="element-ready-single-shopping-cart media">
                     <div class="cart-image element-ready-cart-image">
                          <img src="${item.image_url}" alt="${item.name}">
                      </div>
                  <div class="cart-content media-body pl-15">

                      <h6>
                        <a href="${item.link}">${item.name}</a>
                      </h6>
                      <span class="quality"> QTY:${item.quantity}</span>
                    
                      ${item.subtotal}
                      <a data-product="${index}" class="element-ready-cart-item-remove" href="javascript:void(0);">
                          <i class="fa fa-times"></i>
                      </a>
                  </div>
              </div> <!-- single shopping cart -->
          </li>
       `;
           $html_cart_item.append(item_html);
        });
        
      }
      
    });
    
  }

