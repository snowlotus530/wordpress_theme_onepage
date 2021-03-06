<?php namespace ThemeXpert\Providers\WordPress;

use ThemeXpert\Providers\Contracts\ContentInterface;

/**
 * Class Content
 * @package ThemeXpert\Providers\WordPress
 */
class Content implements ContentInterface {
	/**
	 * @return array
	 */
	public function getPages() {
		return $this->objAsArray( get_pages(), 'ID', 'post_title' );
	}

	/**
	 * @param $obj
	 * @param $oKey
	 * @param $oValue
	 *
	 * @return array
	 */
	protected function objAsArray( $obj, $oKey, $oValue ) {
		$arr = [ ];

		array_walk( $obj, function ( $v, $k ) use ( &$arr, $oKey, $oValue ) {
			$arr[ $v->{$oKey} ] = $v->{$oValue};
		} );

		return $arr;
	}

	/**
	 *
	 */
	public function getPosts() {
		// TODO: Implement getPosts() method.
	}

	/**
	 * @return array
	 */
	public function getMenus() {
		return $this->objAsArray( get_terms( 'nav_menu' ), 'term_id', 'name' );
	}

	/**
	 * @return array
	 */
	public function getCategories() {
		return $this->objAsArray( get_terms( 'category' ), 'term_id', 'name' );
	}

	/**
	 *
	 */
	public function getMenuLocations() {
		// TODO: Implement getMenuLocations() method.
	}

	public function isLiveMode() {
		$livemode = array_key_exists( 'livemode', $_GET ) ? $_GET['livemode'] : false;

		return ( ! is_admin() && $this->isOnepage() && $livemode );
	}

	public function isOnepage() {
		$onepager = get_post_meta( $this->getCurrentPageId(), '_onepager_updated', true );

		return $onepager ? true : false;
	}

	public function getCurrentPageId() {
		global $post;

		return $post && $post->ID ? $post->ID : null;
	}
}
