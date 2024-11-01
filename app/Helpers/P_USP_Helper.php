<?php

namespace P_USP\App\Helpers;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_Helper')) {
    class P_USP_Helper
    {
        private static $_instance;

        private static $plugin_file;

        /**
         * Get Class Instance
         * @return P_USP_Helper
         */
        public static function instance()
        {
            if (self::$_instance == null) {
                self::$_instance = new self();
            }
            self::$plugin_file = p_usp()::$PLUGIN_FILE;

            return self::$_instance;
        }

        /**
         * Get Plugin Data
         * @return object
         */
        public static function get_plugin_data()
        {
            return (object)get_plugin_data(self::$plugin_file, false);
        }

        /**
         * Get Plugin URL
         *
         * @param $path
         *
         * @return string
         */
        public static function get_plugin_url($path = '')
        {
            return plugins_url($path, self::$plugin_file);
        }

        /**
         * Get Plugin DIR
         *
         * @param string $path
         *
         * @return string
         */
        public static function plugin_dir($path = '')
        {
            return plugin_dir_path(self::$plugin_file).$path;
        }

    }
}
