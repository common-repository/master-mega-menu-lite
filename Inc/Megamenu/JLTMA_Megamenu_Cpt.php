<?php 
namespace JLTELMM\Inc\Megamenu;

defined( 'ABSPATH' ) || exit;

class JLTMA_Megamenu_Cpt{
    
    private static $_instance = null;

    public function __construct() {        
        add_action( 'init', [$this, 'post_types'] );
        add_filter( 'single_template', array( $this, 'load_canvas_template' ) );
    }

    public function post_types() {
        
        $labels = array(
            'name'                  => _x( 'Master Addons Items', 'Post Type General Name', 'master-mega-menu-lite' ),
            'singular_name'         => _x( 'Master Addons Item', 'Post Type Singular Name', 'master-mega-menu-lite' ),
            'menu_name'             => esc_html__( 'Master Addons item', 'master-mega-menu-lite' ),
            'name_admin_bar'        => esc_html__( 'Master Addons item', 'master-mega-menu-lite' ),
            'archives'              => esc_html__( 'Item Archives', 'master-mega-menu-lite' ),
            'attributes'            => esc_html__( 'Item Attributes', 'master-mega-menu-lite' ),
            'parent_item_colon'     => esc_html__( 'Parent Item:', 'master-mega-menu-lite' ),
            'all_items'             => esc_html__( 'All Items', 'master-mega-menu-lite' ),
            'add_new_item'          => esc_html__( 'Add New Item', 'master-mega-menu-lite' ),
            'add_new'               => esc_html__( 'Add New', 'master-mega-menu-lite' ),
            'new_item'              => esc_html__( 'New Item', 'master-mega-menu-lite' ),
            'edit_item'             => esc_html__( 'Edit Item', 'master-mega-menu-lite' ),
            'update_item'           => esc_html__( 'Update Item', 'master-mega-menu-lite' ),
            'view_item'             => esc_html__( 'View Item', 'master-mega-menu-lite' ),
            'view_items'            => esc_html__( 'View Items', 'master-mega-menu-lite' ),
            'search_items'          => esc_html__( 'Search Item', 'master-mega-menu-lite' ),
            'not_found'             => esc_html__( 'Not found', 'master-mega-menu-lite' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'master-mega-menu-lite' ),
            'featured_image'        => esc_html__( 'Featured Image', 'master-mega-menu-lite' ),
            'set_featured_image'    => esc_html__( 'Set featured image', 'master-mega-menu-lite' ),
            'remove_featured_image' => esc_html__( 'Remove featured image', 'master-mega-menu-lite' ),
            'use_featured_image'    => esc_html__( 'Use as featured image', 'master-mega-menu-lite' ),
            'insert_into_item'      => esc_html__( 'Insert into item', 'master-mega-menu-lite' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'master-mega-menu-lite' ),
            'items_list'            => esc_html__( 'Items list', 'master-mega-menu-lite' ),
            'items_list_navigation' => esc_html__( 'Items list navigation', 'master-mega-menu-lite' ),
            'filter_items_list'     => esc_html__( 'Filter items list', 'master-mega-menu-lite' ),
        );
        $rewrite = array(
            'slug'                  => 'mastermega-content',
            'with_front'            => true,
            'pages'                 => false,
            'feeds'                 => false,
        );        
        $args = array(
            'label'                 => esc_html__( 'Master Addons Item', 'master-mega-menu-lite' ),
            'description'           => esc_html__( 'mastermega_content', 'master-mega-menu-lite' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'elementor', 'permalink' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => false,
            'show_in_menu'          => false,
            'menu_position'         => 5,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'publicly_queryable' => true,
            'rewrite'               => $rewrite,
            'query_var' => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
            'rest_base'             => 'mastermega-content',
        );
        register_post_type( 'mastermega_content', $args );
    }

    function load_canvas_template( $single_template ) {

        global $post;

        if ( 'mastermega_content' == $post->post_type ) {

            $elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

            if ( file_exists( $elementor_2_0_canvas ) ) {
                return $elementor_2_0_canvas;
            } else {
                return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
            }
        }

        return $single_template;
    }    
}