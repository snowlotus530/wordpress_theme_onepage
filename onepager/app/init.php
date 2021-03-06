<?php

//DASHBOARD
if ( is_admin() ) {
	onepager()->menu()->add(
		'onepager', //slug
		'Onepager', //menu title
		'WordPress Onepager', //page title
		'App\Controllers\AdminMenuController@getIndex',
		onepager()->url( 'resources/images/dashicon-onepager.svg' )
	);
}


//LIVE MODE TOOLBAR
add_action( 'wp', function () {
	$url   = League\Url\Url::createFromUrl( getCurrentPageURL() );
	$query = $url->getQuery();

	if ( onepager()->content()->isLiveMode() ) {
		$query->modify( array( 'livemode' => false ) );

		onepager()->toolbar()->addMenu( 'op-disable-livemode', $url, '<span class="fa fa-circle"></span> Disable Build Mode</span>' );
		onepager()->toolbar()->addMenu( 'op-add-block', '', '<span class="fa fa-plus"></span> Add Block' );
	} else {
    if(!onepager()->content()->isOnepage()){
      return;
    }
		$query->modify( array( 'livemode' => true ) );

		onepager()->toolbar()->addMenu( 'op-enable-livemode', $url, '<span class="fa fa-circle"></span> Enable Build Mode' );
	}
} );

//inject onepager
add_filter( 'the_content', function ( $content ) {
	$pageId = onepager()->content()->getCurrentPageId();

	if ( onepager()->content()->isLiveMode() ) {
		return '<div class="wrap"> <div id="onepager-mount"></div> </div>';
	}

	if ( onepager()->content()->isOnepage() ) {
		$sections = onepager()->section()->all( $pageId );

		return onepager()->render()->sections( $sections );
	}

} );
