(function( $ ) {
	'use strict';

	$(document).ready(function(){
		$("#publish").click(function(e){
		e.preventDefault();
		var discount = $('#discountbox').val();
		// alert(val);
		//alert(val);
		discount = parseInt(discount);
		var regular = $("#regularbox").val();
		// alert(reg);
		//alert(reg);
		regular = parseInt(regular);
		if(discount > regular) {
		$('#error').html("Discount Price must be less than Regular price");
		}
		else {
		$("#post").submit();
		}
		});
		});

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );
