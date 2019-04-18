jQuery(document).ready(function ($) {
	var AJAXURL 				= wpcargoAJAXHandler.ajax_url;
	var vat_percentage 			= wpcargoAJAXHandler.vat_percentage;
	var deleteElementMessage 	= wpcargoAJAXHandler.deleteElementMessage;
	var autoFillPlaceholder 	= wpcargoAJAXHandler.autoFillPlaceholder;
	var wpcargoDateFormat 		= wpcargoAJAXHandler.date_format;
	var wpcargoTimeFormat 	 	= wpcargoAJAXHandler.time_format;

	'use strict';
	var sum = 0;
	$('.wpc-repeater').repeater({
		defaultValues: {
			'wpc-pm-qty': '',
			'wpc-pm-length': '',
			'wpc-pm-width': '',
			'wpc-pm-height': '',
			'wpc-pm-description': '',
			'wpc-pm-price': '',

			'p': ''
		},
		show: function () {
			$(this).slideDown;
			$('.wpc-mp-tr').css('display','');
			calculateSum();

			$(".price").on("keydown keyup", function() {
				calculateSum();
			});
		},
		hide: function (deleteElement) {
			if(confirm( deleteElementMessage)) {
				$(this).slideUp(deleteElement);
				setTimeout(function(){
					calculateSum();
					$(".price").on("keydown keyup", function() {
						calculateSum();
					});
				}, 500);
			}
		}
	})

	$(".wpcargo-datepicker").datepicker({dateFormat: wpcargoDateFormat});
	$(".wpcargo-timepicker").timepicker({timeFormat: wpcargoTimeFormat});

	calculateSum();

	$(".price").on("keydown keyup", function() {
		calculateSum();
	});

	function calculateSum() {
		var sum = 0;
		//iterate through each textboxes and add the values
		$(".price").each(function() {
		//add only if the value is number

			if (!isNaN(this.value) && this.value.length != 0) {
				sum += parseFloat(this.value);
				$(this).css("background-color", "#FEFFB0");
			}
			else if (this.value.length != 0){
				$(this).css("background-color", "red");
			}
		});

		var mp_subtotal = sum.toFixed(2);
		var mp_vat = sum * vat_percentage;
		var mp_total = parseFloat(mp_subtotal)+parseFloat(mp_vat);

		$("input#wpc-total-price").val(mp_total.toFixed(2));

		$("span.wpc-pm-subtotal-text").html(mp_subtotal);
		$("span.wpc-pm-vat-text").html(mp_vat.toFixed(2));
		$("span.wpc-pm-tp-text").html(mp_total.toFixed(2));
	}

	$('.misc-pub-section.wpc-status-section, #shipment-bulk-update').on('change', 'select.wpcargo_status', function( e ){
		e.preventDefault();
		var status = $(this).val();
		if( status ){
			$('.wpc-status-section .date').prop('required',true);
			$('.wpc-status-section .time').prop('required',true);
			$('.wpc-status-section .status_location').prop('required',true);
			$('.wpc-status-section .remarks').prop('required',true);
		}else{
			$('.wpc-status-section .date').prop('required',false);
			$('.wpc-status-section .time').prop('required',false);
			$('.wpc-status-section .status_location').prop('required',false);
			$('.wpc-status-section .remarks').prop('required',false);
		}
	});

	// Autofill Shipper and Receiver section
	$('#reg-shipper').on('change', function() {	
		var selectedValue = $(this).val();
		var shipper_name  = $('input#wpcargo_shipper_name').val();
		var shipper_phone = $('input#wpcargo_shipper_phone').val();
		var shipper_address = $('input#wpcargo_shipper_address').val();
		var shipper_email = $('input#wpcargo_shipper_email').val();
		$.ajax({
			type:"POST",
			data:{
				action:'autofill_information',	
				userID:selectedValue,
			},
			dataType: 'JSON',
			url : AJAXURL,
			beforeSend:function(){
				$('#reg-shipper-container .spinner').css("visibility", "visible");
			},
			success:function(data){
				$('#reg-shipper-container .spinner').css("visibility", "hidden");
				if( shipper_name == '' ){
					$('input#wpcargo_shipper_name').val( data.user_full_name );
				}
				if( shipper_phone == '' ){
					$('input#wpcargo_shipper_phone').val( data.user_company_phone );
				}
				if( shipper_address == '' ){
					$('input#wpcargo_shipper_address').val( data.user_address );
				}
				if( shipper_email == '' ){
					$('input#wpcargo_shipper_email').val( data.user_email );
				}	
			}
		});	
	});	
	$('#reg-receiver').on('change', function() {	
		var selectedValue = $(this).val();
		var parentID = $(this).parent().parent().parent().parent().parent().attr('id');
		var receiver_name  = $('input#wpcargo_receiver_name').val();
		var receiver_phone = $('input#wpcargo_receiver_phone').val();
		var receiver_address = $('input#wpcargo_receiver_address').val();
		var receiver_email = $('input#wpcargo_receiver_email').val();
		$.ajax({
			type:"POST",
			data:{
				action:'autofill_information',	
				userID:selectedValue,
			},
			dataType: 'JSON',
			url : AJAXURL,
			beforeSend:function(){
				$('#reg-receiver-container .spinner').css("visibility", "visible");
			},
			success:function(data){
				// console.log( data );
				$('#'+parentID+' #reg-receiver-container .spinner').css("visibility", "hidden");
				if( receiver_name == '' ){
					$('input#wpcargo_receiver_name').val( data.user_full_name );
				}
				if( receiver_phone == '' ){
					$('input#wpcargo_receiver_phone').val( data.user_company_phone );
				}
				if( receiver_address == '' ){
					$('input#wpcargo_receiver_address').val( data.user_address );
				}
				if( receiver_email == '' ){
					$('input#wpcargo_receiver_email').val( data.user_email );
				}	
			}
		});	
	});
	$("#reg-shipper, #reg-receiver").select2({
		  placeholder: autoFillPlaceholder,
		  allowClear: true
	});
});