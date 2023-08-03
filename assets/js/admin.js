/* global jQuery, ModPagespeed */

/**
 * @param ModPagespeed.ajaxUrl
 * @param ModPagespeed.action
 * @param ModPagespeed.nonce
 */

jQuery( document ).ready( function( $ ) {
	let msgTimer;

	function clearMessages() {
		$( '#ps-success' ).html( '' ).hide();
		$( '#ps-error' ).html( '' ).hide();

		clearTimeout( msgTimer );
	}

	function showMessage( el, message ) {
		$( el ).html( message ).slideDown( 'slow' );

		msgTimer = setTimeout( function() {
			$( el ).html( '' ).slideUp( 'slow' );
		}, 5000 );
	}

	function ajaxCall( data ) {
		clearMessages();

		$.ajax( {
			url: ModPagespeed.ajaxUrl,
			type: 'post',
			data: data,
			success: function( response ) {
				if ( response.success ) {
					showMessage( '#ps-success', response.data );
				} else {
					showMessage( '#ps-error', response.data );
				}
			},
			error: function( response ) {
				showMessage( '#ps-error', response.data );
			}
		} );
	}

	$( '#purge_styles, #purge_entire_cache' ).on( 'click', function() {
		const data = {
			action: ModPagespeed.action,
			nonce: ModPagespeed.nonce,
			id: $( this ).attr( 'id' )
		};

		ajaxCall( data );
	} );

	$( '#dev_mode' ).on( 'change', function() {
		const checked = $( this ).is( ':checked' );

		if ( checked ) {
			$( this ).parent().addClass( 'active' );
		} else {
			$( this ).parent().removeClass( 'active' );
		}

		const data = {
			action: ModPagespeed.action,
			nonce: ModPagespeed.nonce,
			id: $( this ).attr( 'id' ),
			checked: checked
		};

		ajaxCall( data );
	} );
} );
