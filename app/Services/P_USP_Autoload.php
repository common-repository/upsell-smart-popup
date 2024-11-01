<?php

namespace P_USP\App\Services;

use P_USP\App\Admin\Product\P_USP_Enhanced_Product_Data_Tab;
use P_USP\App\Admin\Settings\P_USP_Settings;
use P_USP\App\Admin\Setup\P_USP_Admin_Scripts;
use P_USP\App\Admin\Setup\P_USP_Plugin_Setup;
use P_USP\App\Admin\Setup\P_USP_Public_Scripts;
use P_USP\App\Frontend\Controllers\P_USP_General_Hooks;
use P_USP\App\Frontend\TemplateRender\P_USP_CartCheckout_Template;
use P_USP\App\Frontend\TemplateRender\P_USP_Product_Template;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_Autoload')) {
    final class P_USP_Autoload
    {
        private static $_instance;

        /**
         * Get Class Instance
         * @return P_USP_Autoload
         */
        public static function instance()
        {
            if (self::$_instance == null) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Get Class Instance
         *
         * @param $class
         *
         * @return mixed
         */
        private static function instantiate($class)
        {
            return new $class();
        }

        /**
         * Classes
         * @return string[]
         */
        private static function services()
        {
            $services = [
                P_USP_Public_Scripts::class,
                P_USP_General_Hooks::class,
                P_USP_Product_Template::class,
                P_USP_CartCheckout_Template::class,
            ];
            if (is_admin()) {
                $services[] = P_USP_Admin_Scripts::class;
                $services[] = P_USP_Plugin_Setup::class;
                $services[] = P_USP_Settings::class;
                $services[] = P_USP_Enhanced_Product_Data_Tab::class;
            }

            return $services;
        }

        /**
         * Autoload Classes
         * @return void
         */
        public static function register_services()
        {
            foreach (self::services() as $class) {
                $service = self::instantiate($class);
                if (method_exists($service, 'init')) {
                    $service->init();
                }
            }
        }
    }
}