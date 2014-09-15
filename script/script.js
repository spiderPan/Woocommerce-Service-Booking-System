jQuery(document).ready(function ($) {
	var formats = ["MM d, yy", "MM d, yy"],

		datePickField = $('.calculator-type-datepicker'),
		startDateField = $('#calculator-leave-date'),
		endDateField = $('#calculator-back-date'),
		inspectionField = $('#calculator-inspection-times'),
		seniorField = $('#calculator-senior-check'),
		calculateField = $('.calculate-required'),
		qtyField = $('#quantity_product_input'),
		woocommerceQtyField = $('.input-text.qty');

	datePickField.val("").datepicker({dateFormat : formats[1], minDate : 1});

	calculateField.on('change', function () {
		var startDate = startDateField.datepicker('getDate'),
			endDate = endDateField.datepicker('getDate'),
			inspectionDays = inspectionField.val(),
			diff = 0,
			qty = 0;

		if (startDate && endDate && $.isNumeric(inspectionDays)) {
			diff = Math.floor((endDate.getTime() - startDate.getTime()) / 86400000);
			qty = Math.floor(diff / inspectionDays);
		}
		qtyField.val(qty);
		woocommerceQtyField.val(qty);
	});
});