$(function() {
	$('[name="toggleAdvancedOptions"]').change(function() {
		if ($('[name="toggleAdvancedOptions"]').is(':checked')) {
			$('.advanced').show();
		} else {
			$('.advanced').hide();
		}
	});
});