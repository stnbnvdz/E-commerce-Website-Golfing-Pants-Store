jQuery(document).ready(function($) {
	$(document).on('change', 'select.wps-costs-per-store', function() {
		wps_js_update_store_costs($(this).find('option:selected').data('cost'));
	});

	$(document).on('updated_checkout', function() {
		if($('#store_shipping_cost').length) {
			if($('#store_shipping_cost').val() == '' && $('select.wps-costs-per-store').val() > 0) {
				wps_js_update_store_costs($('select.wps-costs-per-store').find('option:selected').data('cost'));
			}
		}
	});

	function wps_js_update_store_costs(cost) {
		$('#store_shipping_cost').val(cost);
		$('body').trigger('update_checkout');
	}
});