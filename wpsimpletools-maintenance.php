<?php

/*
 * Plugin Name: WpSimpleTools Maintenance Mode
 * Description: Puts the site in maintenance mode, redirects all non-authenticated requests to a basic page (included in the plugin) or custom URL.
 * Author: WpSimpleTools
 * Author URI: https://profiles.wordpress.org/wpsimpletools/#content-plugins
 * Version: 1.2.1
 * Plugin Slug: wpsimpletools-maintenance
 * Text Domain: wpsimpletools-maintenance-mode
 */
if (! defined('ABSPATH')) {
    die('Don\'t call this file directly.');
}

include_once 'wpsimpletools-maintenance-admin.php';

function wpst_m_process_redirect() {

    $enabled = esc_attr(get_option('enabled'));
    $redirect_url = esc_attr(get_option('url'));
    $maintenancePage = esc_attr(get_option('maintenancePage'));
    
    $url_parts = explode('/', $_SERVER['REQUEST_URI']);
    
    if ($enabled) {
        
        if (in_array('wp-admin', $url_parts)) {
            
            // admin - no redirect
        } else if (current_user_can('manage_options')) {
            
            // user is logged - no redirect
        } else if (in_array('wpsimpletools-maintenance', $url_parts)) {
            
            // maintenance page - no redirect
        } else if ($maintenancePage == 'CUSTOM') {
            
            // redirect
            header('Location: ' . $redirect_url);
            die();
        } else {
            
            // default page
            include 'comingsoon/comingsoon.php';
            exit();
        }
    }
}
add_action('send_headers', 'wpst_m_process_redirect', 1);

function wpst_m_deactivation() {

    delete_option('enabled');
    delete_option('maintenancePage');
    delete_option('url');
    delete_option('pageTitle');
    delete_option('pageText');
}
register_deactivation_hook(__FILE__, 'wpst_m_deactivation');
