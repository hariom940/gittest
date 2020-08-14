$(document).on('keydown','.number', function(e) {
			if(!((e.keyCode > 95 && e.keyCode < 106)
			  || (e.keyCode > 47 && e.keyCode < 58) 
			  || e.keyCode == 8)) {
				return false;
			}
});

$(document).ready(function(){
  $('div#list_popover').hide();
})

var frontendLocalizationString;
$(document).ready(function() 
{
   if($('#frontend_all_msg_with_localization').length>0){
		frontendLocalizationString = JSON.parse( $('#frontend_all_msg_with_localization').val() );
	}
	 /**
	*** Product Add To Cart ***
	*/

  //ajax request for add to cart
  if($('.add-to-cart-bg').length>0 || $('.single-page-add-to-cart').length>0){
    dynamicAddToCart();
  }
});

var dynamicAddToCart= function(){
  $('.add-to-cart-bg, .single-page-add-to-cart').on('click', function(e){
    e.preventDefault();
    var dataObj = {};
    //var target  = null;
    
    //var attr = $(this).attr('data-target');
    
//    if (typeof attr !== typeof undefined && attr !== false) {
//      attr = $(this).data('target');
//    }
    
    dataObj['product_id'] = $(this).data('id');

    if($('#quantity').length>0){
      dataObj['qty'] = parseInt( $('#quantity').val() );
    }
    else{
      dataObj['qty'] = 1;
    }
    
    $('#shadow-layer, .add-to-cart-loader').show();
    $.ajax({
        url: base_url + '/ajax/add-to-cart',
        type: 'POST',
        cache: false,
        datatype: 'json',
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        data: dataObj,

        success: function(data){
          if(data && data == 'zero_price'){
            $('#shadow-layer, .add-to-cart-loader').hide();
            swal("" , 'The product price can not be zero.' );
          }
          else if(data && data == 'out_of_stock'){
            $('#shadow-layer, .add-to-cart-loader').hide();
            swal("" , 'The product is out of stock. Please try later.' );
          }
          else if(data && data == 'item_added'){
            $.ajax({
                url: base_url + '/ajax/get-mini-cart-data',
                type: 'POST',
                cache: false,
                datatype: 'json',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },

                success: function(data){
                    console.log(data.html);
                  if(data.status && data.status == 'success' && data.type == 'mini_cart_data' && data.html){
                    $('.cart').html( data.html );
                    swal("Success!", "Product Added to Cart!", "success");
                      location.reloadsetTimeout(function(){ location.reload(); }, 2000);
                    $('#shadow-layer, .add-to-cart-loader').hide();

                    if($('.show-mini-cart').length>0){
                      $('.show-mini-cart').off('click').on('click', function(e){
                        e.preventDefault();
                        e.stopPropagation();

                        $('#list_popover').fadeToggle();return false;
                      });
                    }

                    $('#list_popover').fadeIn();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    return false;
                  }
                },
                error:function(){}
            });
          }
        },
        error:function(){}
    });
  });
}

if($('#apply_coupon_post').length>0){
    $('#apply_coupon_post').on('click', function(e){
      e.preventDefault();
      if($('#apply_coupon_code').val().length == 0 && $('#apply_coupon_code').val() == ''){
        $('#apply_coupon_code').css({'border' : '1px solid #f06953'});
        return false
      }
      else{
        $('#apply_coupon_code').css({'border' : '1px solid #cccccc'});
        applyCoupon( $('#apply_coupon_code').val() );
      }
    });
}

 $(document).ready(function(){
 	var msgStr = '<div class="alert alert-danger" style="margin-left:-15px; margin-right:15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><div class="message-header"><i class="fa fa-exclamation-triangle"></i>&nbsp;<strong>Message</strong></div><p class="error-msg-coupon"></p></div>';
 	$(document).on('click', 'a.cart-btn', function(){
 		var val = $(this).attr('href');
 		if(val == '#'){
 			$('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
            $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html('Please calculate shipping first.');
            $('html, body').animate({
        			scrollTop: $("#cart_page, #checkout_page").offset().top
    		}, 2000);
            setTimeout(function(){ $('#cart_page, #checkout_page').find('.error-msg-coupon').parents('.alert-danger').remove(); }, 9000); 
 			return false;
 		}else{
 			return true;
 		}
 	});
 });
 
 function applyCoupon( val ){

    var msgStr = '<div class="alert alert-danger" style="margin-left:-15px; margin-right:15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><div class="message-header"><i class="fa fa-exclamation-triangle"></i>&nbsp;<strong>Message</strong></div><p class="error-msg-coupon"></p></div>';
    var msgStr2 = '<div class="alert alert-success" style="margin-left:-15px; margin-right:15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><div class="message-header"><i class="fa fa-exclamation-triangle"></i>&nbsp;<strong>Message</strong></div><p class="error-msg-coupon"></p></div>';
    $('div.page-loader').show();
    
    $.ajax({
          url: base_url + '/ajax/apply-coupon',
          type: 'POST',
          cache: false,
          dataType: 'json',
          data: { _couponCode: val },
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            if($('#cart_page, #checkout_page').find('.error-msg-coupon').length>0){
              $('#cart_page, #checkout_page').find('.error-msg-coupon').parents('.alert-danger').remove();
            }
            
            if(data.error == true && data.error_type == 'no_coupon_data'){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html('Coupon does not exist!');
            }
			      else if(data.error == true && data.error_type == 'less_from_min_amount' && data.min_amount){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( 'The minimum spend for this coupon is' + ' '+ data.min_amount);
            }
						else if(data.error == true && data.error_type == 'exceed_from_max_amount' && data.max_amount){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( 'The maximum spend for this coupon is' + ' '+ data.max_amount);
            }
			      else if(data.error == true && data.error_type == 'no_login'){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( 'need to login as a user for using this coupon' );
            }
            else if(data.error == true && data.error_type == 'coupon_limited'){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( 'This coupon can not be used any more because of usage restriction.' );
            }
			      else if(data.error == true && data.error_type == 'coupon_expired'){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( 'Now this coupon has expired' );
            }
            else if(data.error == true && data.error_type == 'coupon_already_apply'){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( 'Sorry, this coupon already exist' );
            }
            else if(data.success == true && (data.success_type == 'discount_from_product' || data.success_type == 'percentage_discount_from_product' || data.success_type == 'discount_from_total_cart' || data.success_type == 'percentage_discount_from_total_cart')){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr2);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( 'Your coupon successfully added');
              $('#cart_page .cart-grand-total, #checkout_page .cart-grand-total').before(
                  '<div class="form-group row cart-coupon"><div class="col-md-6"><label>Discount : </label>' +
                  '</div>' +
                  '<div class="col-md-6">' +
                  '<h6>'+ data.discount_price +'</h6>' +
                  '<button class="remove-coupon btn c-btn btn-lg c-theme-btn c-btn-square c-font-white c-font-bold c-font-uppercase c-cart-float-r cart-btn checkOutBtn hvr-wobble-horizontal" type="button"><i class="fal fa-trash-alt"></i>Remove coupon</button>' +
                  '</div>' +
                  '</div>');

              $('#cart_page .cart-grand-total .value, #checkout_page .cart-grand-total .value').html( data.grand_total );
			        $('#list_popover span.value').html( data.grand_total );
            }
            else if(data.error == true && data.error_type == 'exceed_from_cart_total'){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( 'Discount price can not be greater than from cart total' );
            }
            $('html, body').animate({
        			     scrollTop: $("#cart_page, #checkout_page").offset().top
    		    }, 2000);
            setTimeout(function(){ $('#cart_page, #checkout_page').find('.error-msg-coupon').parents('.alert-danger').remove(); }, 9000); 
            
            $('div.page-loader').hide();
          },
          error:function(){}
    });
 }

 
 $(document).on('click','#remove_redeem_points_amount', function(e){
    e.preventDefault();
      var msgStr = '<div class="alert alert-success" style="margin-left:-15px; margin-right:15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><div class="message-header"><i class="fa fa-exclamation-triangle"></i>&nbsp;<strong>Message</strong></div><p class="error-msg-coupon"></p></div>';
    
  $('div.page-loader').show();
    
    $.ajax({
          url: base_url + '/ajax/remove-points',
          type: 'POST',
          cache: false,
          dataType: 'json',
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            $('div.page-loader').hide();
            if(data.success == true){
                $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
                $('li.redeem_points').remove();
                $('#cart_page .cart-coupon, #checkout_page .cart-coupon').remove();
                $('#cart_page .cart-grand-total .value, #checkout_page .cart-grand-total .value').html( data.grand_total );
                $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( 'Points discount removed successfully');
                $('html, body').animate({
                   scrollTop: $("#cart_page, #checkout_page").offset().top
                }, 2000);
                setTimeout(function(){ $('#cart_page, #checkout_page').find('.error-msg-coupon').parents('.alert-danger').remove(); }, 9000); 
                $('.cart-total-area-overlay').hide();
                $('#loader-1-cart').hide();
            }
          },
          error:function(){}
    });
 })

 $(document).on('click','.remove-points', function(e){
    e.preventDefault();
      removePoints();
 })

 function removePoints(){
  var msgStr = '<div class="alert alert-success" style="margin-left:-15px; margin-right:15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><div class="message-header"><i class="fa fa-exclamation-triangle"></i>&nbsp;<strong>Message</strong></div><p class="error-msg-coupon"></p></div>';
    
  $('div.page-loader').show();
    
    $.ajax({
          url: base_url + '/ajax/remove-points',
          type: 'POST',
          cache: false,
          dataType: 'json',
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            $('div.page-loader').hide();
            if(data.success == true){
              location.reload(true);
            }
          },
          error:function(){}
    });
 }


 $(document).on('click','.remove-coupon', function(e){
	  e.preventDefault();
      removeCoupon();
 })


 
 function removeCoupon(){
 	var msgStr = '<div class="alert alert-success" style="margin-left:-15px; margin-right:15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><div class="message-header"><i class="fa fa-exclamation-triangle"></i>&nbsp;<strong>Message</strong></div><p class="error-msg-coupon"></p></div>';
    
	$('div.page-loader').show();
    
    $.ajax({
          url: base_url + '/ajax/remove-coupon',
          type: 'POST',
          cache: false,
          dataType: 'json',
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            $('div.page-loader').hide();
            if(data.success == true){
                $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('input#apply_coupon_code').val('');
			        $('#cart_page .cart-coupon, #checkout_page .cart-coupon').remove();
              $('#cart_page .cart-grand-total .value, #checkout_page .cart-grand-total .value').html( data.grand_total );
              $('#list_popover span.value').html( data.grand_total );
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( 'Your coupon removed successfully');
              $('html, body').animate({
        			   scrollTop: $("#cart_page, #checkout_page").offset().top
    		      }, 2000);
              setTimeout(function(){ $('#cart_page, #checkout_page').find('.error-msg-coupon').parents('.alert-danger').remove(); }, 9000); 
              $('.cart-total-area-overlay').hide();
              $('#loader-1-cart').hide();
            }
          },
          error:function(){}
    });
 }
 
$(document).ready(function () {
   
		var form = $('#newsletter');
		form.submit(function(e) {
			e.preventDefault();
      $('div.page-loader').show();
			$.ajax({
				url     : base_url + '/ajax/newsletter-subscription',
				type    : 'POST',
				data    : form.serialize(),
				dataType: 'json',
				success : function ( data )
				{
          $('div.page-loader').hide();
					if(data.errors) {
						$.each(data.errors, function (key, value) {
							//$('.'+key+'-error').html(value);
							$('input[name="'+key+'"]').closest('div.form-group').addClass('has-error');
							$('input[name="'+key+'"]').focus();
						});
                	}
					if(data.success == 1){
						form.prepend('<div class="alert alert-success alert-dismissable"> <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success! </strong> '+data.msg+'</div>')
						setTimeout(function(){ $('.alert').remove(); }, 5000);
						form[0].reset();
					}
					if(data.warning == 2){
						form.prepend('<div class="alert alert-danger alert-dismissable"> <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning! </strong> '+data.msg+'</div>');
						setTimeout(function(){ $('.alert').remove(); }, 5000);
						form[0].reset();
					}
				},
				error: function( json )
				{
					if(json.status === 422) {
						$.each(json.responseJSON, function (key, value) {
							//$('.'+key+'-error').html(value);
							$('input[name="'+key+'"]').closest('div.form-group').addClass('has-error');
						});
					} else {
						  // Error
              // alert('Incorrect credentials. Please try again.') 
					}
				}
			});
		});
	 
	});
	
	
	$(document).on('click', 'a.shipping-calculator-button', function(){
	 	$('section.shipping-calculator-form').toggle();
 	})
	
	$(document).on('change', 'select#calc_shipping_country',  function() {
    $('div.page-loader').show();
    if(this.value == 'US'){
        $('input#calc_shipping_postcode').attr('maxlength', 5);
    }else{
        $('input#calc_shipping_postcode').attr('maxlength', 8);
    }
	  $.ajax({
			url: base_url + '/ajax/get-states/'+this.value,
			type: 'POST',
			cache: false,
			data : { 'country_code' :  this.value },
			dataType: 'html',
			headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
			success: function(data){

				  $('div.page-loader').hide();
          if(data != ''){
				    $('#calc_shipping_state').html(data);
          }
          else{
            $('#calc_shipping_state').html('<option value=""> </option>');
          }
				  $('.cart-total-area-overlay').hide();
				  $('#loader-1-cart').hide();
				
			  },
		  error:function(){}
		});
	});

  $(document).on('change', 'select#billing_country',  function() {
    $('div.page-loader').show();
    var country_code = this.value;
    if(country_code == 'US'){
        $('input#billing_postcode').attr('maxlength', 5);
    }else{
        $('input#billing_postcode').attr('maxlength', 8);
    }

    $.ajax({
      url: base_url + '/ajax/get-states/'+country_code,
      type: 'POST',
      cache: false,
      data : { 'country_code' :  country_code },
      dataType: 'html',
      headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
      success: function(data){
          $('div.page-loader').hide();
          $('#billing_state').html(data);
          $('.cart-total-area-overlay').hide();
          $('#loader-1-cart').hide();
        
        },
      error:function(){}
    });
  });

  
  $(document).on('change', 'select#shipping_country',  function() {
    $('div.page-loader').show();
    if(this.value == 'US'){
        $('input#shipping_postcode').attr('maxlength', 5);
    }else{
        $('input#shipping_postcode').attr('maxlength', 8);
    }
    $.ajax({
      url: base_url + '/ajax/get-states/'+this.value,
      type: 'POST',
      cache: false,
      data : { 'country_code' :  this.value },
      dataType: 'html',
      headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
      success: function(data){
          $('div.page-loader').hide();
          $('#shipping_state').html(data);
          $('.cart-total-area-overlay').hide();
          $('#loader-1-cart').hide();
        
        },
      error:function(){}
    });
  });
	
	
	$(document).ready(function () {
 
		var form = $('form.woocommerce-shipping-calculator');
		form.submit(function(e) { 
			e.preventDefault();
      $('div.page-loader').show();
			$.ajax({
				url     :  base_url + '/ajax/calculate-shipping',
				type    : 'POST',
				data    : form.serialize(),
				dataType: 'json',
				headers: { 'X-CSRF-TOKEN' : $('form.woocommerce-shipping-calculator input[name="_token"]').val() },
				success : function ( data )
				{
					$('div.page-loader').hide();	
					if(data.response == 1){
						$('.shipping_options').html(data.message);
            $('#list_popover span.value').html( data.grand_total );
            $('#cart_page .cart-tax-total .tvalue, #checkout_page .cart-tax-total .tvalue').html( data.tax );
						$('#cart_page .cart-grand-total .value, #checkout_page .cart-grand-total .value').html( data.grand_total );
			  		$('#list_popover span.value').html( data.grand_total );
            $('section.shipping-calculator-form').hide();	
					}
					if(data.response == 2){
						form.prepend('<div class="alert alert-danger alert-dismissable"> <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning!</strong> '+data.message+' </div>');
						setTimeout(function(){ $('.alert').remove(); }, 3000);	
					}
				},
				error: function( json )
				{
					
				}
			});
		});
	 
	});
  var xhr = null;
  $(document).on('keyup','.input_text', function(){
      if( xhr != null ) {
                xhr.abort();
                xhr = null;
      }
      if ($('input#checkbox6-444').prop('checked')) {
            var shipping_country  = $('#shipping_country').val();
            var shipping_state    = $('#shipping_state').val();
            var postcode          = $('#shipping_postcode').val();
      }else{
            var shipping_country  = $('#billing_country').val();
            var shipping_state    = $('#billing_state').val();
            var postcode          = $('#billing_postcode').val();
      }

      var form = $('#checkout');
      
      xhr = $.ajax({
        url     :  base_url + '/ajax/calculate-shipping',
        type    : 'POST',
        data    : {calc_shipping_country:shipping_country, calc_shipping_state:shipping_state,calc_shipping_postcode:postcode},
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        success : function ( data )
        {
          $('div.page-loader').hide();  
          if(data.response == 1){
            $('.shipping_options').html(data.message);
            $('#cart_page .cart-grand-total .value, #checkout_page .cart-grand-total .value').html( data.grand_total );
            $('#list_popover span.value').html( data.grand_total );
            $('section.shipping-calculator-form').hide(); 
          }
          if(data.response == 2){
            form.prepend('<div class="alert alert-danger alert-dismissable"> <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning!</strong> '+data.message+' </div>');
            setTimeout(function(){ $('.alert').remove(); }, 3000);  
          }
        },
        error: function( json )
        {
          
        }
      });
  });

  $(document).on('change', 'input#checkbox6-444', function(){
        if($(this).is(":checked")) {
              var shipping_country  = $('#shipping_country').val();
              var shipping_state    = $('#shipping_state').val();
              var postcode          = $('#shipping_postcode').val();
        }else{
              var shipping_country  = $('#billing_country').val();
              var shipping_state    = $('#billing_state').val();
              var postcode          = $('#billing_postcode').val();
        }

        var form = $('#checkout');
      
        xhr = $.ajax({
          url     :  base_url + '/ajax/calculate-shipping',
          type    : 'POST',
          data    : {calc_shipping_country:shipping_country, calc_shipping_state:shipping_state,calc_shipping_postcode:postcode},
          dataType: 'json',
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success : function ( data )
          {
            $('div.page-loader').hide();  
            if(data.response == 1){
              $('.shipping_options').html(data.message);
              $('#cart_page .cart-grand-total .value, #checkout_page .cart-grand-total .value').html( data.grand_total );
              $('#list_popover span.value').html( data.grand_total );
              $('section.shipping-calculator-form').hide(); 
            }
            if(data.response == 2){
              form.prepend('<div class="alert alert-danger alert-dismissable"> <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning!</strong> '+data.message+' </div>');
              setTimeout(function(){ $('.alert').remove(); }, 3000);  
            }
          },
          error: function( json )
          {
            
          }
        });     
  });

	
	$(document).on('click','.shipping_method', function(){
			$('div.page-loader').show();
			$.ajax({
				url     :  base_url + '/ajax/update-shipping-charges',
				type    : 'POST',
				data    : { ship : $(this).val() },
				dataType: 'json',
				headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
				success : function ( data )
				{	
          $('div.page-loader').hide();
					if(data.response == 1){
						$('#cart_page .cart-grand-total .value, #checkout_page .cart-grand-total .value').html( data.grand_total );
			  		$('#list_popover span.value').html( data.grand_total );
						$('a.c-cart-float-r').attr("href", base_url+'/checkout');
					}else{
						$('a.c-cart-float-r').attr("href", "#");
					}
					/*if(data.response == 2){
						form.prepend('<div class="alert alert-danger alert-dismissable"> <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning!</strong> '+data.message+' </div>');
						setTimeout(function(){ $('.alert').remove(); }, 3000);
						
					}*/
				},
				error: function( json )
				{
					
				}
			});	
	});

	$(document).on('click','.cancel_checkout',function(){
		$('form#checkout')[0].reset();
 	})

 	$('form#checkout').on('submit', function(e){
 		e.preventDefault();
    $('div.page-loader').show();
    var check = $('form#checkout').serialize();
 		$.ajax({
	            
              url: base_url + '/checkout',
	            type:'POST',
	            data: check,
	            headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
	            success: function(data) {
	                if($.isEmptyObject(data.error)){
                    if(data.method == 'paypal'){
	                	    window.location.href = base_url + '/payment/'+data.last_order_id;
                    }else{
                        Payeezy(check, data.last_order_id, data.total_amount);
                        //Quickbooks(check, data.last_order_id, data.total_amount);
                    }
	                }else{
                    $('div.page-loader').hide();
	                	printErrorMsg(data.error);
	                	$('html, body').animate({
					             scrollTop: $("div.print-error-msg").offset().top - 100
					          }, 2000);
	                }
	            }
	        });
 	});

  function Payeezy(data, order_id, total_amount){
    $.ajax({
      url: base_url + '/payeezy/'+order_id,
      type:'POST',
      data: data,
      headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
      success: function(dataq) {
          //console.log(dataq);
          var json_obj = $.parseJSON(dataq);//parse JSON
          if(json_obj.hasOwnProperty('error')){
              $('div.page-loader').hide();
              printErrorMsg(json_obj.error);
              $('html, body').animate({
                  scrollTop: $("div.print-error-msg").offset().top - 100
              }, 2000);
              setTimeout(function(){ location.reload(false);}, 3000);
          }else{
              $('#payeezy_input').val(JSON.stringify(json_obj.data));
              $('form#payeezy').submit();
          }
      }
    });
  }

  function Quickbooks(data, order_id, total_amount){
    //Handling Quickbooks payment Gateway
    $('div.page-loader').show();
    $.ajax({
      url: base_url + '/quickbooks/docs/merchant_services/example_merchant_service.php?order_id='+order_id+'&order_amount='+total_amount,
      type:'POST',
      data: data,
      headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
      success: function(dataq) {
          //console.log(dataq);
          var json_obj = $.parseJSON(dataq);//parse JSON
          if(json_obj.hasOwnProperty('error')){
              $('div.page-loader').hide();
              printErrorMsg(json_obj.error);
              $('html, body').animate({
                  scrollTop: $("div.print-error-msg").offset().top - 100
              }, 2000);
              setTimeout(function(){ location.reload(false);}, 3000);
          }else{
              $('#qbms_input').val(JSON.stringify(json_obj.data));
              $('form#qbms').submit();
          }
      }
    });
  }



 	function printErrorMsg (msg) {
			$(".print-error-msg").find("ul").html('');
			$(".print-error-msg").css('display','block');
			$.each( msg, function( key, value ) {
				$(".print-error-msg").find("ul").append('<li>'+value+'</li>');
			});
	}

  $(document).on('click','a.read_more_testimonial', function(e){
    e.preventDefault();
    $('#myModal').html('');
    $('#myModal').modal('hide');
    var attr = $(this).attr('data-id');
    $('div.page-loader').show();
    $.ajax({
      url: base_url + '/testimonial/detail/'+attr,
      type:'GET',
      datatype: 'html',
      headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
      success: function(dataq) {
          //console.log(dataq);
          $('div.page-loader').hide();
          $('#myModal').html(dataq);
          $('#myModal').modal('show');
      }
    });
  });

  $(document).ready(function(){ 
    $('a.apply-redemption').on('click', function(e){
      e.preventDefault();
      var url = base_url+'/ajax/apply-discount?points=';
      var points = $('input#points').val();
      if(points.length > 0){
              $.ajax({
                url: url+points,
                type: 'POST',
                cache: false,
                datatype: 'json',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },

                success: function(data){
                  //console.log(data);
                  if(data.success){
                      swal("Success!", "Points redeemed successfully!", "success")
                      setTimeout(function () {
                        location.reload(true);
                      }, 2000);
                    return false;
                  }
                },
                error:function(){
                  swal("No points was found to redeem!");
                }
            });
        }else{
            $('div.modal .modal-body .error_msg h2').text('Please enter points before apply');
            return false;
        }
        /*swal({
            text: 'How many points would you like to apply?',
            content:  {
                element: "input",
                attributes: {
                  placeholder: "Enter points to redeem",
                  type: "number",
                  className:'number'
                },
              },
            button: {
              text: "Apply",
              closeModal: false,
            },
          }, function(){
            var points = $('input.number').val();
            $.ajax({
                url: url+points,
                type: 'POST',
                cache: false,
                datatype: 'json',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },

                success: function(data){
                  //console.log(data);
                  if(data.success){
                      swal("Success!", "Points redeemed successfully!", "success")
                      setTimeout(function () {
                        location.reload(true);
                      }, 2000);
                    return false;
                  }
                },
                error:function(){
                  swal("No points was found to redeem!");
                }
            });
          });*/
    });
});

/*wishlist add*/
$(document).ready(function(){
$(".wishlistadd-button").click(function(){
    var product_id = $(this).attr('data-id');
    $('.add-to-cart-loader-wishlist').show();
    $.ajax({
        type: 'POST',
        cache: false,
        datatype: 'json',
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        url: base_url + '/ajax/add-to-wishlist',
        data: {
        product_id: product_id,
        },
        success: function(data){
              //alert(data)
            if(data && data == "This product already added in wish list"){
               $('.add-to-cart-loader-wishlist').hide();
                swal("" , 'This product already added in wish list');
                $(".check-wishlist"+product_id).removeClass('fa-heart-o');
                $(".check-wishlist"+product_id).addClass('fa-heart');
            }else if(data && data=="Wishlist added successfully!" ){
                $.ajax({
                url: base_url + '/ajax/get-mini-cart',
                type: 'POST',
                cache: false,
                datatype: 'json',
                headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},

                success: function(data){
                  if(data.status && data.status == 'success' && data.type == 'mini_cart_data' && data.html){
                    //$(".check-wishlist"+product_id).attr('<i class="fa fa-heart" aria-hidden="true"></i>');

                    $(".check-wishlist"+product_id).removeClass('fa-heart-o');
                    $(".check-wishlist"+product_id).addClass('fa-heart');

                    $('.cart-list').html( data.html );
                      swal("Success!", "Product Added to Wishlist!", "success")
                      location.reloadsetTimeout(function(){ location.reload(); }, 2000);
                    $('#shadow-layer, .add-to-cart-loader-wishlist').hide();
                    if($('.show-mini-cart-wish-cart').length>0){
                      $('.show-mini-cart-wish-cart').off('click').on('click', function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        $('.popover-list').fadeToggle();
                        return false;
                      });
                    }
                    $('.popover-list').fadeIn();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    return false;
                  }
                },
                error:function(){}
            });
            }else if(data && data=="Please Login first"){
            $('.add-to-cart-loader-wishlist').hide();
            swal("" , 'Please log in to use the Wishlist feature');
            setTimeout(function(){ window.location = base_url+"/login"; }, 3000);         

            /*swal("" , 'Please log in to use the Wishlist feature')
              .then(willRedirect => {
              if(willRedirect) {
                window.location.href = base_url+"/login";
              }
            })*/
            }
           /* location.reload();*/

       },

       
    })
});
});