<?php
/**
 * Plugin Name: CF7 Contact To Active Campaign
 * Requires Plugins:  Contact Form 7
 * Author: Bitcraftx Team
 * Description: Send Data to AC (Active Campaign) works with Contact form 7. After The submission of form by contact form 7, the submitted data will be sent to Active campaign account.
 * Version: 1.0
 * Author URI: https://bitcraftx.com/
 * * Text Domain: cft-to-ac
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
define('SEND_DATA_TO_AC_ROOT', __FILE__);
define('CF7_DATA_TO_AC_URL', plugins_url('/', SEND_DATA_TO_AC_ROOT));
define('CF7_DATA_TO_AC_PATH', plugin_dir_path(SEND_DATA_TO_AC_ROOT));
define('CF7_DATA_TO_AC_BASE', plugin_basename(SEND_DATA_TO_AC_ROOT));

//Required File
require_once(CF7_DATA_TO_AC_PATH . 'includes/class.sdtac-installer.php');
require_once(CF7_DATA_TO_AC_PATH . 'includes/class.cf7-to-ac.php');