/**
 Core Shop layout handlers and wrappers
 **/

// BEGIN: Layout Brand
var LayoutQtySpinner = function () {
	return {
		//main function to initiate the module
		init: function () {
			$('.c-spinner .btn:first-of-type').on('click', function () {
				var data_input = $(this).attr('data_input');
				var data_max = ($(this).data('maximum')) ? $(this).data('maximum') : 1000;
				if ($('.c-spinner input.' + data_input).val() < data_max) {
					$('.c-spinner input.' + data_input).val(parseInt($('.c-spinner input.' + data_input).val(), 1000) + 1);
				}			
			});

			$('.c-spinner .btn:last-of-type').on('click', function () {
				var data_input = $(this).attr('data_input');
				if ($('.c-spinner input.' + data_input).val() != 0) {
					$('.c-spinner input.' + data_input).val(parseInt($('.c-spinner input.' + data_input).val(), 1000) - 1);
				}
			});
		}

	};
}();
// END

// Main theme initialization
$(document).ready(function () {
	// init layout handlers
	LayoutQtySpinner.init();
});