/** PARGO 2.0.9 Wordpress Plugin Javascript File **/

$(document).ready(function () {
    localStorage.removeItem('pargo-select');
     var shippingMethod = $("input:radio.shipping_method:checked").val();
         if(!shippingMethod) {
            shippingMethod = $(".shipping_method").val();
         }
         

         
         
     
         
    $( document.body ).on( 'updated_checkout', function() {
        
                 $( ".shipping_method" ).change(function() {
                     
                     if($(this).val() !== 'wp_pargo'){
                             localStorage.removeItem('pargo-select');
                     }
                     
                
});
        
              
         var shippingMethod = $("input:radio.shipping_method:checked").val();
         if(!shippingMethod) {
            shippingMethod = $(".shipping_method").val();
         }
                 if (shippingMethod === 'wp_pargo' ) {
                     

                     if(localStorage.getItem('pargo-select') == null) {
                                 $('#place_order').prop('disabled', true);
                     }
                     else{
                                                          $('#place_order').prop('disabled', false);

                     }
                    
                      $('#ship-to-different-address').hide();
                      $('#pargo_map_block').show();
                      $('#parcel_test_field').show();
                      $('.insur-info').show();
        
}
else {

                      $('#ship-to-different-address').show();
                      $('#pargo_map_block').hide();
                      $('#parcel_test_field').hide();
                      $('.insur-info').hide();
                      if ($('#parcel_test').prop('checked')) {
                          $('#parcel_test').prop('checked',false); 
                          $(document.body).trigger('update_checkout');

}
                     
}

      if (shippingMethod === 'wp_pargo' && localStorage.getItem('pargo-select') !== null  ) {
                                 $('.pargo-info-box').show();
                                 $('#pargo_map_block').hide();


                    }
                    else if (shippingMethod === 'wp_pargo' && localStorage.getItem('pargo-select') === null){
                                 $('.pargo-info-box').hide();
                                 $('#pargo_map_block').show();
                    }
                    
                    else {
                                 $('.pargo-info-box').hide();
                                 $('#pargo_map_block').hide();
                    }

    });
    
 
    
    if (window.addEventListener) {
        window.addEventListener("message", selectPargoPoint, false);
    } else {
        window.attachEvent("onmessage", selectPargoPoint);
    }

    function selectPargoPoint(item) {
        if (item.data.storeName !== undefined) {
            $('#pargo-store-name').text(item.data.storeName);
            $('#pargo-store-address').text(item.data.address1 + ', ' + item.data.suburb);
            $('#pargo-store-hours').text(item.data.businessHours);
            $("#pargo-store-img").prop("src",item.data.photo);
            $('.pargo-info-box').show("slow");
            $('#pargo_map_block').hide("slow");

            localStorage.setItem('pargo-select', true);

            $('body').trigger('update_checkout', {update_shipping_method: true});
            placeOrderBtn(false);
        }
    }

    $(".opening-hours-pargo-btn").click(function () {
        $(".open-hours-pargo-info").toggle("slow")
    });

    $(".pargo-toggle-map").click(function () {
        $('.pargo-info-box').hide("slow");
        $('#pargo_map_block').show("slow");
        $('body').trigger('update_checkout', {update_shipping_method: true});
        placeOrderBtn(false);
        localStorage.removeItem('pargo-select');

    });

    function placeOrderBtn(value) {
        $('#place_order').prop('disabled', value);
    }
});


jQuery(document).ready(function($){



    function openPargoModal() {



    //get value of map token hidden input

    var pargoMapToken = $('#pargomerchantusermaptoken').val();



    $( ".pargo-cart" ).append($( "<div id='pargo_map'><div id='pargo_map_center'><div id='pargo_map_inner'><div class='pargo_map_close'>x</div><iframe id='thePargoPageFrameID' src='https://map.pargo.co.za/?token=" +pargoMapToken+ "' width='100%' height='100%' name='thePargoPageFrame' ></iframe></div></div></div>" ));

    $('#pargo_map').fadeIn(300);



    $('.pargo_map_close').on('click',function(){

      $('#pargo_map').fadeOut(300);

    });



    };





  var pargo_button = "#select_pargo_location_button";

  $(pargo_button).click(function(){

  openPargoModal();

  });



  var body = $('body');

  body.on('click', '#select_pargo_location_button', function () {

        openPargoModal();

  });

  $('#parcel_test_field').after( '<span class="insur-info">insurance terms</span>' );

  body.on('click', '.insur-info', function () {
	if ($('#parcel_test').is(':checked')) {
		$('#modal-trigger-insurance').attr('checked','checked');
	}else{
		$('#modal-trigger-insurance').attr('checked','');
	}
  });





  if (window.addEventListener) {

    window.addEventListener("message", selectPargoPoint, false);

  } else {

      window.attachEvent("onmessage", selectPargoPoint);



  }



  /** After Pargo Pickup Point is Selected **/

  function selectPargoPoint(item){

        var data = null;

      if(item.data.pargoPointCode){

          localStorage.setItem('pargo-shipping-settings', JSON.stringify(item.data));

          data = JSON.parse(localStorage.getItem('pargo-shipping-settings'));

          var pargoButtonCaptionAfter = $('#pargobuttoncaptionafter').val();

          $("#select_pargo_location_button").html(pargoButtonCaptionAfter);

      }

      else {

          data = JSON.parse(localStorage.getItem('pargo-shipping-settings'));

      }



      var saveData = $.ajax({

      type: 'POST',

      url: ajax_object.ajaxurl,

      data: {pargoshipping:data},

      success: function(resultData) {

        if(item.data.photo !=""){

      $("#pick-up-point-img").attr("src", item.data.photo);

      $("#pargoStoreName").text(item.data.storeName);

      $("#pargoStoreAddress").text(item.data.address1);

      $("#pargoBusinessHours").text(item.data.businessHours);



   }

       //close the map

       $( "#pargo_map" ).hide( "slow", function() {});



   }





  });



  saveData.error(function() { alert("Something went wrong"); });

  //console.log(item.data);

  }







  // Click checkout - make sure point is selected

  body.on('click', 'a.checkout-button.button.alt.wc-forward, #place_order', function(e){



    if ( ($('input[value="wp_pargo"]').is(':checked')) || ($('input[value="wp_pargo"]').is(':hidden')) ){

            if ($('#pargoStoreName').is(':empty')){

                e.preventDefault();

        $('#pargo-not-selected').addClass('show-warn');


            };

        }

    });





  $('#pargo-not-selected').on('click',function(){

    $(this).removeClass('show-warn');

  });



  //end click checkout


});





