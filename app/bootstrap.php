<?php
use Pimple\Container;
use ThemeXpert\Onepager\Adapters\WordPress;
use ThemeXpert\Onepager\Onepager;
use Whoops\Handler\PrettyPageHandler;

function onepager()
{
    static $onepager;

    if (!$onepager) {
        $onepager = new Onepager(
            new WordPress(new Container, ONEPAGER_PATH, ONEPAGER_URL),
            new Container
        );
    }

    return $onepager;
}


function tx_add_svg_upload_support($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

function tx_add_build_mode_button_to_toolbar()
{
    $isOnepage = onepager()->content()->isOnepage();
    $isLiveMode = onepager()->content()->isBuildMode();

    if ($isOnepage && !$isLiveMode) {
        $url = getOpBuildModeUrl(getCurrentPageURL(), true);

        onepager()->toolbar()->addMenu(
            'op-enable-livemode',
            $url,
            '<span class="fa fa-circle"></span> Enable Build Mode'
        );
    }

    //hide the navbar when livemode
    if ($isLiveMode) {
        show_admin_bar(false);
    }
}


/**
 * LOAD ALL BLOCKS BEFOREHAND
 * WE WILL NEED THEM IN OUR AJAX REQUESTS
 */
function tx_load_default_onepager_blocks()
{
  onepager()->blockManager()->loadAllFromPath(
    ONEPAGER_BLOCKS_PATH,
    ONEPAGER_BLOCKS_URL,
    'onepager' //default group added to the blocks (optional array)
  );
}

function tx_set_block_groups_order()
{
  onepager()->blockManager()->setGroupOrder(array(
    "navbars",
    "headers",
    "contents",
    "portfolios",
    "teams",
    "testimonials",
    "blogs",
    "sliders",
    "pricings",
    "footers",
    "themes"
  ));
}

/** FIXME: NOT USED ANYWHERE YET **/
function tx_cache_onepager_blocks(){
  $cache_file = onepager()->path("blocks/blocks.cache");

  if (!file_exists($cache_file) && is_writable(dirname($cache_file))) {
    $blocks = (array)onepager()->blockManager()->all();

    file_put_contents(
      $cache_file,
      json_encode($blocks)
    );
  }
}


/**
 * Add page Templates
 */
function tx_load_onepager_page_templates()
{
  $pageTemplater = new ThemeXpert\WordPress\PageTemplater();
  $pageTemplater->addTemplate('OnePager', onepager()->path("/app/views/onepage.php"));
}

/**
 * Add preset layouts
 */
function tx_load_onepager_presets()
{
  onepager()->layoutManager()->loadAllFromPath(
    ONEPAGER_PRESETS_PATH,
    ONEPAGER_PRESETS_URL
  );
}




/** WordPress Action Hooks **/
add_action('wp', 'tx_add_build_mode_button_to_toolbar');
add_action('admin_init', 'tx_load_onepager_presets');
add_action('plugins_loaded', 'tx_load_onepager_page_templates');
add_action('plugins_loaded', 'tx_set_block_groups_order');
add_action('plugins_loaded', 'tx_load_default_onepager_blocks');

/** WordPress Filter Hooks **/
add_filter('upload_mimes', 'tx_add_svg_upload_support');
