<?php
namespace JLTELMM\Inc\Megamenu;

class JLTMA_Megamenu_Nav_Walker extends \Walker_Nav_Menu{

    private $currentItem;
    private static $_instance = null;
    public $menu_Settings;

    // Get Item Custom Method
    public function get_item_meta($menu_item_id){
        $meta_key = JLTMA_Megamenu_Options::$jltma_menuitem_settings_key;
        $data = get_post_meta($menu_item_id, $meta_key, true);
        $data = (array) json_decode($data);

        $format = [
            "menu_id" => null,
            "menu_has_child" => '',
            "menu_enable" => 0,
            "menu_trigger_effect" => 'hover',
            "menu_badge_text" => '',
            "menu_mobile_submenu_content_type" => 'builder_content'
        ];

        return array_merge($format, $data);
    }

    public function is_megamenu($menu_slug){

        $menu_slug = ( ( (gettype($menu_slug) == 'object') && (isset($menu_slug->slug)) ) ? $menu_slug->slug : $menu_slug );

        $cache_key = 'master_megamenu_data_' . $menu_slug;
        $cached = wp_cache_get( $cache_key );
        if ( false !== $cached ) {
            return $cached;
        }

        $return = 0;
        $settings = JLTMA_Megamenu_Options::get_instance()->get_option(JLTMA_Megamenu_Options::$jltma_menu_settings_key,[]);
        $term = get_term_by('slug', $menu_slug, 'nav_menu');

        if(
            isset($term->term_id)
            && isset($settings['menu_location_' . $term->term_id])
            && $settings['menu_location_' . $term->term_id]['is_enabled'] == '1'
        ){

            $return = 1;
        }

        wp_cache_set( $cache_key, $return );
        return $return;
    }

    public function is_megamenu_item($item_meta, $menu){
        if($this->is_megamenu($menu) == 1 && $item_meta['menu_enable'] == 1 && class_exists( 'Elementor\Plugin' ) ){
            return true;
        }
        return false;
    }

    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);

        $output .= "\n$indent<ul class=\"jltma-dropdown jltma-sub-menu dropdown-menu\">\n";
    }
    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     * @since 3.0.0
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    /**
     * Start the element output.
     * @see Walker::start_el()
     * @param int    $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $this->currentItem = $item;

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;


        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

        $class_names .= ' nav-item';
        $item_meta = $this->get_item_meta($item->ID);

        $is_megamenu_item = $this->is_megamenu_item($item_meta, $args->menu);

        if (in_array('menu-item-has-children', $classes) || $is_megamenu_item == true) {
            $class_names .= ' jltma-menu-has-children';
        }

        if (in_array('menu-item-has-children', $classes)) {
            $class_names .= ' dropdown';
        }

        if( $item_meta['menu_trigger_effect'] !=""){
            $class_names .= ' jltma-megamenu-' . $item_meta['menu_trigger_effect'];
        }

        if ($is_megamenu_item == true) {
            $class_names .= ' jltma-has-megamenu';
        }

        if ($item_meta['menu_mobile_submenu_content_type'] == 'builder_content') {
            $class_names .= ' jltma-mobile-builder-content';
        }

        if (in_array('current-menu-item', $classes)) {
            $class_names .= ' active';
        }

        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filter the ID applied to a menu item's list item element.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';
        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';

        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $submenu_indicator = '';



        // New
        if ($depth === 0) {
            $atts['class'] = 'jltma-menu-nav-link nav-link';
        }

        if (in_array('menu-item-has-children', $classes)) {
            $atts['data-toggle']    = 'dropdown';
            $atts['class']          = ' jltma-menu-dropdown-toggle';
        }

        if (in_array('menu-item-has-children', $classes) || $is_megamenu_item == true) {
            $submenu_indicator    .= '<span class="jltma-submenu-indicator"></span>';
        }
        if ($depth > 0) {
            $manual_class = array_values($classes)[0] .' '. 'dropdown-item';
            $atts ['class']= $manual_class;
        }
        if (in_array('current-menu-item', $item->classes)) {
            $atts['class'] .= ' active';
        }

        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        $item_output = $args->before;

        $item_output .= '<a'. $attributes .'>';

        if($this->is_megamenu($args->menu) == 1){

            // add badge text
            if($item_meta['menu_badge_text'] != ''){
                $item_output .= '<span class="jltma-menu-badge">'.$item_meta['menu_badge_text'].'<i style="'.$badge_carret_style.'" class="jltma-menu-badge-arrow"></i></span>';
            }

        }


        /** This filter is documented in wp-includes/post-template.php */
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        $item_output .= '<span class="jltma-menu-label">' . $item->attr_title .'</span>';
        $item_output .= $submenu_indicator . '</a>';
        $item_output .= $args->after;
        /**
         * Filter a menu item's starting output.
         *
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    /**
     * Ends the element output
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ($depth === 0) {
            if($this->is_megamenu($args->menu) == 1){

                $item_meta = $this->get_item_meta($item->ID);

                // if( $item_meta['menu_transition'] !=""){
                //     $menu_transition = $item_meta['menu_transition'];
                // }

                if($item_meta['menu_enable'] == 1 && class_exists( 'Elementor\Plugin' ) ){

                    $builder_post_title = 'mastermega-content-megamenu-menuitem' . $item->ID;
                    $builder_post = get_page_by_title($builder_post_title, OBJECT, 'mastermega_content');
                    $output .= '<ul class="dropdown-menu jltma-megamenu fade-up">';
                    if($builder_post != null){
                        $elementor = \Elementor\Plugin::instance();
                        $output .= $elementor->frontend->get_builder_content_for_display( $builder_post->ID );
                    }else{
                        $output .= esc_html__('Menu content not found', master-mega-menu-lite);
                    }

                    $output .= '</ul>';
                }
            }
            $output .= "</li>\n";
        }
    }
}