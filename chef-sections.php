<?php
/**
 * Plugin Name: Chef Sections
 * Plugin URI: http://chefduweb.nl/cuisine
 * Description: Easily transform boring pages into exciting section-based layouts!
 * Version: 1.2
 * Author: Luc Princen
 * Author URI: http://www.chefduweb.nl/
 * License: GPLv2
 * 
 * @package ChefSections
 * @category Core
 * @author Chef du Web
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
defined('DS') ? DS : define('DS', DIRECTORY_SEPARATOR);


/**
 * Main class that bootstraps the framework.
 */
if (!class_exists('ChefSections')) {

    class ChefSections {
    
        /**
         * Sections bootstrap instance.
         *
         * @var \ChefSections
         */
        private static $instance = null;

        /**
         * Sections version.
         *
         * @var float
         */
        const VERSION = '1.4';


        /**
         * Plugin directory name.
         *
         * @var string
         */
        private static $dirName = '';

        private function __construct(){

            static::$dirName = static::setDirName(__DIR__);

            // Load plugin.
            $this->load();
        }

        /**
         * Init the framework classes
         *
         * @return \ChefSections
         */
        public static function getInstance(){

            if ( is_null( static::$instance ) ){
                static::$instance = new static();
            }
            return static::$instance;
        }

        /**
         * Set the plugin directory property. This property
         * is used as 'key' in order to retrieve the plugins
         * informations.
         *
         * @param string
         * @return string
         */
        private static function setDirName($path) {

            $parent = static::getParentDirectoryName(dirname($path));

            $dirName = explode($parent, $path);
            $dirName = substr($dirName[1], 1);

            return $dirName;
        }

        /**
         * Check if the plugin is inside the 'mu-plugins'
         * or 'plugin' directory.
         *
         * @param string $path
         * @return string
         */
        private static function getParentDirectoryName($path) {

            // Check if in the 'mu-plugins' directory.
            if (WPMU_PLUGIN_DIR === $path) {
                return 'mu-plugins';

            }

            // Install as a classic plugin.
            return 'plugins';
        }

        /**
         * Load the chef sections classes.
         *
         * @return void
         */
        private function load(){

			//auto-loads all .php files in these directories.
        	$includes = array( 
        		'Classes',
                'Classes/Columns',
                'Classes/Sections',
                'Classes/Admin',
                'Classes/Wrappers'
			);

        	$includes = apply_filters( 'chef_sections_autoload_dirs', $includes );

			foreach( $includes as $inc ){
				
				$root = static::getPluginPath();
				$files = glob( $root.$inc.'/*.php' );

				foreach ( $files as $file ){

					require_once( $file );

        	    }
        	}

        }


        /**
         * Set all admin assets
         * 
         * @return void
         */
        function admin_assets(){

           // wp_enqueue_style( 'cuisine', plugins_url( 'Assets/css/admin.css', __FILE__ ) );
            //wp_enqueue_script( 'FieldMedia', admin_url( 'Assets/js/MediaField.js', __FILE__ ) );
        
        }


        public static function getPluginPath(){
        	return __DIR__.DS;
        }

        /**
         * Returns the directory name.
         *
         * @return string
         */
        public static function getDirName(){
            return static::$dirName;
        }

    }
}


/**
 * Load the main class.
 *
 */
add_action('cuisine_loaded', function(){

	ChefSections::getInstance();

});