<?php

/*
  Plugin Name: bbPress Subscriptions - Mandrill
  Plugin URI: http://wedevs.com/
  Description: Mandrill add-on for bbPress subscriptions
  Version: 0.1
  Author: Tareq Hasan
  Author URI: http://tareq.wedevs.com/
  License: GPL2
 */

/**
 * Copyright (c) 2013 Tareq Hasan (email: tareq@wedevs.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */
// don't call the file directly
if ( !defined( 'ABSPATH' ) )
    exit;

/**
 * bbSub_Mandrill class
 *
 * @class bbSub_Mandrill The class that holds the entire bbSub_Mandrill plugin
 */
class bbSub_Mandrill {

    /**
     * Constructor for the bbSub_Mandrill class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @uses register_activation_hook()
     * @uses register_deactivation_hook()
     * @uses is_admin()
     * @uses add_action()
     */
    public function __construct() {

        // Localize our plugin
        add_action( 'init', array($this, 'localization_setup') );

        // Register handler
        add_filter( 'bbsub_handlers', array($this, 'register_handler') );
        
        require_once __DIR__ . '/handler.php';
    }

    /**
     * Initializes the bbSub_Mandrill() class
     *
     * Checks for an existing bbSub_Mandrill() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( !$instance ) {
            $instance = new bbSub_Mandrill();
        }

        return $instance;
    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'bbsm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }
    
    function register_handler( $handlers ) {
        $handlers['mandrill'] = 'bbSubscriptions_Handler_Mandrill';
        
        return $handlers;
    }

}

// bbSub_Mandrill
$bbsm = bbSub_Mandrill::init();
//add_action('plugins_loaded', array('bbSub_Mandrill', 'init'));