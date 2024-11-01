<?php
/*
  * Plugin Name: Upsell Smart Popup
  * Description: An innovative solution designed to enhance your online store's conversion rate and boost sales. With this plugin, you can create captivating pop-up upsell offers that appear immediately after a customer adds a product to their cart, effectively increasing the chances of making an additional sale.
  * Author: Perfexcode
  * Plugin URI: https://wordpress.org/plugins/upsell-smart-popup/
  * Author URI: https://perfexcode.com/
  * Text Domain: upsell-smart-popup
  * Domain Path: /languages/
  * Version: 1.0.1
  * Requires at least: 5.0
  * Requires PHP: 7.0
  * License:  GPL2
  * License URI: https://www.gnu.org/licenses/gpl-2.0.html
  *
  * You should have received a copy of the GNU General Public License'
  * along with Upsell Smart Popup. If not, see <https://www.gnu.org/licenses/>.
  *
  * @since  1.0.0
  * @author Perfexcode
  * @license GPL-2.0+
  * @copyright Copyright (c) 2022, Upsell Smart Popup
*/

use P_USP\App\Services\P_USP_Autoload;


if (!defined('ABSPATH')) exit;
// Plugin File
if (!defined('P_USP_PLUGIN_FILE')):
    define('P_USP_PLUGIN_FILE', __FILE__);
endif;
// Plugin DIR
if (!defined('P_USP_PLUGIN_DIR')):
    define('P_USP_PLUGIN_DIR', __DIR__);
endif;
// Include bootstrap.php
if (!file_exists('P_USP_Autoload')) {
    require_once 'bootstrap.php';
}
// Plugin Loaded Hook
if (!class_exists('P_USP_Autoload')) {
    add_action('plugins_loaded', [new P_USP_Autoload(), 'register_services']);
}