jQuery( function ( $ ) {
	$( document ).foundation();

	var $searchBtnIcon = $ ( '#searchBtnIcon' );

	$( '#searchBtn' ).on( 'click', function () {
		$( '#searchForm' ).toggleClass( 'open' );
		$searchBtnIcon.toggleClass( 'fa-search' );
		$searchBtnIcon.toggleClass( 'fa-times' );
		$( '.site-header__search-input' ).focus();
		ariachange( '#searchForm' );
	});

	$( document ).on( 'click', function( e ) {
		if ( !$.contains( $( '#header' )[0], e.target ) ) {
			$( '#searchForm' ).removeClass( 'open' );
			$searchBtnIcon.addClass( 'fa-search' );
			$searchBtnIcon.removeClass( 'fa-times' );
			ariachange( '#searchForm' );
		}
	});

	ariachange = function( e ) {
		if ( $( e ).hasClass( 'open' ) ) {
			$( e ).attr( 'aria-hidden', 'false' );
		} else {
			$( e ).attr( 'aria-hidden', 'true' );
		}
	};

	$( '#socialCall' ).on( 'click', function () {
		$( '#socialBtn' ).toggleClass( 'open' );
	});
	
	moment.locale( wplocale.momentlocale );
	$( document ).ready( function() {
		$( 'time.timeago' ).each( function( i, elem ) {
			var timeago = moment( $( elem ).text() ).fromNow();
			$( elem ).text( timeago );
		});
	});
});