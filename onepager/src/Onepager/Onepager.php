<?php
namespace ThemeXpert\Onepager;

use Pimple\Container;
use ThemeXpert\Onepager\Adapters\BaseAdapter;
use ThemeXpert\Onepager\Block\BlockCollection;
use ThemeXpert\Onepager\Block\BlockManager;
use ThemeXpert\Onepager\Block\Transformers\ConfigTransformer;
use ThemeXpert\Onepager\Block\Transformers\FieldsTransformer;
use ThemeXpert\Onepager\Block\Transformers\SettingsTransformer;
use ThemeXpert\Providers\Contracts\AdminMenuInterface;
use ThemeXpert\Providers\Contracts\ApiInterface;
use ThemeXpert\Providers\Contracts\AssetInterface;
use ThemeXpert\Providers\Contracts\ContentInterface;
use ThemeXpert\Providers\Contracts\NavigationMenuInterface;
use ThemeXpert\Providers\Contracts\ToolbarInterface;
use ThemeXpert\View\Engines\PhpEngine;
use ThemeXpert\View\View;

class Onepager implements OnepagerInterface {

	public function __construct( BaseAdapter $adapter, Container $container ) {
		$this->adapter   = $adapter;
		$this->container = $container;
		$this->setBlockManager();
		$this->setRenderer();
		$this->setViewProvider();
	}

	public function setBlockManager() {
		$this->container['blockManager'] = function () {
			$blockCollection   = new BlockCollection;
			$configTransformer = new ConfigTransformer(
				new SettingsTransformer(),
				new FieldsTransformer()
			);

			return new BlockManager( $configTransformer, $blockCollection );
		};
	}

	private function setRenderer() {
		$this->container['render'] = function ( $container ) {
			return new Render( $container['view'], $container['blockManager'] );
		};
	}


	public function setViewProvider() {
		$this->container['view'] = function () {
			return new View( new PhpEngine() );
		};
	}

	/**
	 * @return NavigationMenuInterface
	 */
	public function navigationMenu() {
		return $this->adapter->getContainer()['navigationMenu'];
	}

	/**
	 * @return AdminMenuInterface
	 */
	public function menu() {
		return $this->adapter->getContainer()['adminMenu'];
	}

	/**
	 * @return ToolbarInterface
	 */
	public function toolbar() {
		return $this->adapter->getContainer()['toolbar'];
	}

	/**
	 * @return ContentInterface
	 */
	public function content() {
		return $this->adapter->getContainer()['content'];
	}

	/**
	 * @return AssetInterface
	 */
	public function asset() {
		return $this->adapter->getContainer()['asset'];
	}

	/**
	 * @return ApiInterface
	 */
	public function api() {
		return $this->adapter->getContainer()['api'];
	}


	public function security() {
		return $this->adapter->getContainer()['security'];
	}

	public function view() {
		return $this->adapter->getContainer()['view'];
	}

	public function url( $string ) {
		return $this->adapter->getUrl() . $string;
	}

	public function path( $path ) {
		return $this->adapter->getPath() . DIRECTORY_SEPARATOR . $path;
	}

	public function section() {
		return $this->adapter->getContainer()['section'];
	}

	public function blockManager() {
		return $this->container['blockManager'];
	}

	public function render() {
		return $this->container['render'];
	}

}
