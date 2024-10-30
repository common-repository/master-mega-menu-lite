<?php
namespace JLTELMM\Libs;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Assets' ) ) {

	/**
	 * Assets Class
	 *
	 * Jewel Theme <support@jeweltheme.com>
	 * @version     1.0.3
	 */
	class Assets {

		/**
		 * Constructor method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'jltelmm_enqueue_scripts' ), 100 );
			add_action( 'admin_enqueue_scripts', array( $this, 'jltelmm_admin_enqueue_scripts' ), 100 );
			add_action( 'admin_print_scripts', [$this, 'admin_js']);
		}


		/**
		 * Get environment mode
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function get_mode() {
			return defined( 'WP_DEBUG' ) && WP_DEBUG ? 'development' : 'production';
		}

		/**
		 * Enqueue Scripts
		 *
		 * @method wp_enqueue_scripts()
		 */
		public function jltelmm_enqueue_scripts() {

			// CSS Files .
	        wp_enqueue_style( 'bootstrap', JLTELMM_ASSETS . 'css/bootstrap.min.css');
			wp_enqueue_style( 'master-mega-menu-lite-frontend', JLTELMM_ASSETS . 'css/master-mega-menu-lite-frontend.css', JLTELMM_VER, 'all' );

			// JS Files .
			wp_enqueue_script( 'bootstrap', JLTELMM_ASSETS . 'js/bootstrap.min.js', array( 'jquery' ), JLTELMM_VER, true );
			wp_enqueue_script( 'master-mega-menu-lite-frontend', JLTELMM_ASSETS . 'js/master-mega-menu-lite-frontend.js', array( 'jquery' ), JLTELMM_VER, true );


	        $add_inline_script = $this->common_js();
	        wp_add_inline_script('mega-menu-nav-menu', $add_inline_script);


	        $localize_data = array(
	            'plugin_url'    => JLTELMM_URL,
	            'ajaxurl'       => admin_url( 'admin-ajax.php' )
	        );
	        wp_localize_script( 'master-mega-menu-lite-frontend', 'jltma_scripts', $localize_data );			
		}

	    public function common_js(){
	        ob_start(); 
	        ?>
	        var masteraddons = {
	            resturl: '<?php echo get_rest_url() . 'masteraddons/v2/'; ?>',
	        }
	        <?php
	        $output = ob_get_contents();
	        ob_end_clean();
	        return $output;
	    }


	    // Admin Rest API Variable
	    public function admin_js(){
	        echo "<script type='text/javascript'>\n";
	        echo $this->common_js();
	        echo "\n</script>";
	    }


		/**
		 * Enqueue Scripts
		 *
		 * @method admin_enqueue_scripts()
		 */
		public function jltelmm_admin_enqueue_scripts() {

			$screen = get_current_screen();
	        
	        // Only for Nav Menu Pages Scripts/Styles
	        if($screen->base == 'nav-menus'){

	            // CSS Files .
	            wp_enqueue_style( 'wp-color-picker' );
	            wp_enqueue_style( 'bootstrap', JLTELMM_ASSETS . 'css/bootstrap.min.css');
	            wp_enqueue_style( 'mega-menu-style', JLTELMM_ASSETS. 'css/megamenu.css');

	            // Scripts            
	            wp_enqueue_script( 'bootstrap', JLTELMM_ASSETS . 'js/bootstrap.min.js', array( 'jquery' ), JLTELMM_VER, true );
	            wp_enqueue_script( 'icon-picker', JLTELMM_ASSETS . 'js/icon-picker.js', array( 'jquery' ), JLTELMM_VER, true );
	            wp_enqueue_script( 'mega-menu-admin', JLTELMM_ASSETS . 'js/mega-script.js', array( 'jquery', 'wp-color-picker' ), JLTELMM_VER, true );
	            
	            
	            // Localize Scripts
	            $localize_menu_data = array(
	                'resturl'       => get_rest_url() . 'masteraddons/v2/'
	            );      
	            wp_localize_script( 'mega-menu-admin', 'masteraddons', $localize_menu_data );
	           
	        }


	        // CSS
			wp_enqueue_style( 'master-mega-menu-lite-admin', JLTELMM_ASSETS . 'css/master-mega-menu-lite-admin.css', array( 'dashicons' ), JLTELMM_VER, 'all' );


			// JS Files .
			wp_enqueue_script( 'master-mega-menu-lite-admin', JLTELMM_ASSETS . 'js/master-mega-menu-lite-admin.js', array( 'jquery' ), JLTELMM_VER, true );
			wp_localize_script(
				'master-mega-menu-lite-admin',
				'JLTELMMCORE',
				array(
					'admin_ajax'        => admin_url( 'admin-ajax.php' ),
					'recommended_nonce' => wp_create_nonce( 'jltelmm_recommended_nonce' ),
				)
			);


		}
	}
}