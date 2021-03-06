<?php namespace App\Controllers;

class ApiController {
	function saveSections() {
		$sections = $_POST['sections'];
		$updated  = $_POST['updated'];
		$pageId   = $_POST['pageId'];
		$response = [ ];

		$section = array_key_exists( $updated, $sections ) ? $sections[ $updated ] : false;

		//TODO: Improve this
		onepager()->section()->save( $pageId, $sections );

		if ( $section ) {
			$response["content"] = onepager()->render()->section( $section );
			$response["style"]   = onepager()->render()->style( $section );
		}

		$response["success"] = true;

		//TODO: better response
		op_send_json( $response );
	}

	function addMenu() {
		$menuId    = $_POST['menuId'];
		$itemTitle = $_POST['itemTitle'];
		$itemId    = $_POST['itemId'];

		onepager()->navigationMenu()->addItem( $menuId, $itemTitle, $itemId );

		//TODO: better response
		op_send_json_success();
	}
}
