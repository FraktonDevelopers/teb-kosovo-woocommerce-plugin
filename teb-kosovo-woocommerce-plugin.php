<?php
/*
Plugin Name:       Teb Kosovo WooCommerce Payment Gateway
Plugin URI:        #
Description:       A plugin that helps the customer to setup their Teb Payment Provider in their WooCommerce Shop. This plugin is especially for Kosovo and might not work on all countries.
Version:           1.0.0
Author:            Edon Sekiraqa
*/;

if (!defined('ABSPATH')){
    exit;
}

//start the session if already not started
if(!session_id()){
    session_start();
}

add_action('plugins_loaded', 'init_teb_woo_plugin');

if(!function_exists('init_teb_woo_plugin')){
    function init_teb_woo_plugin(){
        /*
            The class WC_Payment_Gateway should exists in order to make this plugin work. Otherwise it means that WooCommerce
            is not being used in this site.
        */
        if(!class_exists('WC_Payment_Gateway')){
            return; // simply stop the process here.
        }

        define('TEB_PAYMENT_PROVIDER_LOADED');

        // require the WC_Payment_Gateway class for TEB Gateway.
        require_once 'utility/TebUtility.php';
        TebUtility::instance();

        require_once 'gateway/TebPaymentGateway.php';

    }
}