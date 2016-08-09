<?php
//Global script version for custom scripts
$version = '0.93';

function my_theme_enqueue_styles() {
    global $version;
    
    /* BOOTSTRAP */
    wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.css', array(), '1.0.0' );
    
    /* HOVER */
    wp_enqueue_style( 'hover', get_stylesheet_directory_uri() . '/css/hover-min.css', array(), '1.0.0' );
    
        /* CHILD AND PARENT STYLE */
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), $version, true);

}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function my_theme_enqueue_scripts() {
    global $version;
    /* ANGULAR */
    wp_enqueue_script('angular', get_stylesheet_directory_uri() . '/js/assets/angular.js', array(), null, true);
    wp_enqueue_script('angular_animate', get_stylesheet_directory_uri() . '/js/assets/angular-animate.js', array(), null, true);
    wp_enqueue_script('angular_touch', get_stylesheet_directory_uri() . '/js/assets/angular-touch.js', array(), null, true);

    /* BOOTSTRAP */
    wp_enqueue_script('ui_bootstrap_tpls_min', get_stylesheet_directory_uri() . '/js/assets/ui-bootstrap-tpls-1.3.3.min.js', array(), null, true);
    
    /* MATERIALIZE JS */
     wp_enqueue_script('materialize_js', get_stylesheet_directory_uri() . '/js/assets/materialize.min.js', array(), null, true);

    /* DIAMOND APP */
    wp_enqueue_script('diamond_app', get_stylesheet_directory_uri() . '/js/app/diamondApp.js', array(), $version, true);
    wp_enqueue_script('start_ctrl', get_stylesheet_directory_uri() . '/js/app/controllers/startCtrl.js', array(), $version, true);
    wp_enqueue_script('start_svc', get_stylesheet_directory_uri() . '/js/app/services/startSvc.js', array(), $version, true);
    wp_enqueue_script('scroll_svc', get_stylesheet_directory_uri() . '/js/app/services/scrollSvc.js', array(), $version, true);
    
    /* JS VARIUOS */
    wp_enqueue_script('js_functions', get_stylesheet_directory_uri() . '/js/jsFunctions.js', array(), $version, true);
    wp_enqueue_script('embed', get_stylesheet_directory_uri() . '/js/embed.js', array(), $version, true);


}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_scripts' );

/* CUSTOM FUNCTIONS */
/********************/
/**
* Add custom fields to api
*/
function json_api_prepare_post( $post_response, $post, $context ) {
	$field = get_post_custom($post['ID']);
	$post_response['custom-fields'] = $field;
	return $post_response;
}
add_filter( 'json_prepare_post', 'json_api_prepare_post', 10, 3 );

/**
 * Custom walker class.
 */
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
 
    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Depth-dependent classes.
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            'menu-depth-' . $display_depth
        );
        $class_names = implode( ' ', $classes );
 
        // Build HTML for output.
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }
 
    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
 
        // Depth-dependent classes.
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
 
        // Passed classes.
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
 
        // Build HTML.
        $output .= $indent . '<li class="nav-item">';
 
        // Link attributes.
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="nav-link"';
 
        // Build HTML output and pass through the proper filter.
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

?>