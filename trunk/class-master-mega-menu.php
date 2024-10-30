<?php
// namespace MasterMegaMenu;

defined( 'ABSPATH' ) || exit;

if( !class_exists('Master_Mega_Menu') ){
	class Master_Mega_Menu{

		public $dir;
		
		public $url;

		private static $plugin_path;

	    private static $plugin_url;

	    private static $_instance = null;

	    const VERSION = "1.0.0";

		private static $plugin_name = 'Master Mega Menu';	    
			
	    public function __construct(){
			
			$this->jltma_constants();

	        // Current Path
	        $this->dir = dirname(__FILE__) . '/';

			$this->url = self::plugin_url() . '/master-mega-menu/';		

			// Include Files
			$this->jltma_include_files();

			add_action('plugins_loaded', [$this, 'jltma_megamenu_plugins_loaded']);

			

		}





	}
}

/*
* Returns Instanse of the Master Mega Menu
*/
if( !function_exists('jltma_megamenu')){
    function jltma_megamenu(){
        return  Master_Mega_Menu::get_instance();
    }
}

jltma_megamenu();