(function($) {

	$(document).ready(function () {

		/**
		 * Toggle staff member bio.
		 */
		$('body').on('click', '.staff-grid__trigger', function(e) {
			e.preventDefault();

			// close other info panels
			$(this).closest('.staff-grid__item').siblings().find('.staff-grid__trigger').removeClass('is-expanded').next('.staff-grid__content').slideUp(250);

			// expand the info panel
			$(this).toggleClass('is-expanded').next('.staff-grid__content').slideToggle(250);

			$('.staff-grid__content__close').click(function() {
				$('.staff-grid__trigger').removeClass('is-expanded').next('.staff-grid__content').slideUp(250);
			});
		});

		/**
		 * Filter staff members.
		 */
		$('.staff-grid__filter__link').click( function(e) {

			// Prevent default action
			 e.preventDefault();

			// Get location slug from title attirbute
			var selected_location = $(this).attr('title');

			$('.staff-grid__filter__link').removeClass('selected');
			$(this).addClass('selected');

			$('.staff-grid').fadeOut();

			data = {
				action: 'filter_staff',
				filter_nonce: filter_vars.filter_nonce,
				location: selected_location,
			};

			$.ajax({
				type: 'post',
				dataType: 'json',
				url: filter_vars.filter_ajax_url,
				data: data,
				beforeSend:function() {
					$('.staff-grid__loading').animate({'opacity' : '1', 'min-height' : '60vh'}, 300);
				},
				success: function( data, textStatus, XMLHttpRequest ) {
					$('.staff-grid__loading').animate({'opacity' : '0', 'min-height' : '0', 'max-height' : '0'}, 300);
					$('.staff-grid').html( data.response );
					$('.staff-grid').fadeIn();
				},
				error: function( MLHttpRequest, textStatus, errorThrown ) {
					$('.staff-grid').html( 'No staff found' );
					$('.staff-grid').fadeIn();
				}
			});

		});

	});

})(jQuery);