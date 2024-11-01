<?php

namespace P_USP\App\Services;

use P_USP\App\Frontend\Controllers\P_USP_Cart_Helper;
use P_USP\App\Frontend\Controllers\P_USP_DB_Model;
use P_USP\App\Helpers\P_USP_Helper;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_Bootstrap')) {
    final class P_USP_Bootstrap
    {
        private static $_instance;

        public static $PLUGIN_FILE = P_USP_PLUGIN_FILE;

        public static $PLUGIN_DIR = P_USP_PLUGIN_DIR;

        public static $PLUGIN_BASENAME;

        public static $PLUGIN_VERSION = '1.0.1';

        public static $IS_DEV_MOD = false;

        public static $AJAX_NONCE = 'p_usp_ajaxnonce';

        /**
         * Get Class Instance
         * @return P_USP_Bootstrap
         */
        public static function instance()
        {
            if (self::$_instance == null) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Class Constructor
         */
        public function __construct()
        {
            self::$PLUGIN_BASENAME = plugin_basename(self::$PLUGIN_FILE);
            add_action('init', [$this, 'init']);
        }

        /**
         * Add/Remove Necessary Actions/Filters
         * @return void
         */
        public function init() {}

        /**
         * Get General Helpers class.
         * @return P_USP_Helper
         */
        public function helper()
        {
            return P_USP_Helper::instance();
        }

        /**
         * Get Database class.
         * @return P_USP_DB_Model
         */
        public function db()
        {
            return P_USP_DB_Model::instance();
        }

        /**
         * Get Database class.
         * @return P_USP_Cart_Helper
         */
        public function cart_handler()
        {
            return P_USP_Cart_Helper::instance();
        }
    }
}