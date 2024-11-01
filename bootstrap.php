<?php

use P_USP\App\Services\P_USP_Bootstrap;
use P_USP\App\Admin\Setup\P_USP_Plugin_Activate;

require_once 'vendor/autoload.php';
/**
 * Init Bootstrap
 * @return P_USP_Bootstrap
 */
if (!function_exists('p_usp')):
    function p_usp()
    {
        return P_USP_Bootstrap::instance();
    }
endif;
// Plugin Register Ativation Hook
if (!function_exists('p_usp_plugin_activation')):
    function p_usp_plugin_activation($network_wide)
    {
        P_USP_Plugin_Activate::activate($network_wide);
    }

    register_activation_hook(P_USP_PLUGIN_FILE, __NAMESPACE__.'\p_usp_plugin_activation');
endif;
