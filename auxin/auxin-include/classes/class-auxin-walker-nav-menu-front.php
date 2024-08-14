<?php
/**
 * Create HTML list of nav menu items for Front-end.
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
class Auxin_Walker_Nav_Menu_Front extends Walker_Nav_Menu {

    protected $in_megamenu               = false;
    protected $megamenu_col_num          = 1;
    private   $root_menu_items_num       = 0;
    private   $root_menu_items_counter   = 1;
    public    $has_logo_spacer_in_middle = false;

    /**
     * Starts the list before the elements are added.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $megamenu_class = 'aux-submenu';
        $megamenu_class .= is_rtl() ? ' aux-temp-left' : '';

        if( $this->in_megamenu && 0 == $depth ){
            $megamenu_class .= ' aux-megamenu';
        } elseif( $this->in_megamenu && 1 == $depth ){
            // remove 'aux-submenu' from ul if it was column container
            $megamenu_class  = 'aux-menu-list-container';
        }

        $indent = str_repeat("\t", $depth + 2); //@EDIT
        $output .= sprintf( "\n$indent<ul class=\"sub-menu %s\">\n", $megamenu_class );

        // if it is a lvl in mega menu
        if( $this->in_megamenu ){
            // if it is the direct lvl after mega menu item
            if( 0 == $depth ){
                $output .= "$indent\t<!-- start mega row -->\n";
                $output .= "$indent\t<li class=\"aux-menu-row\">\n\n";

                $output .= "$indent\t<!-- start mega column container -->\n";
                $output .= "$indent\t<ul class=\"aux-menu-columns\">\n";

            }

        }
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth + 2); //@EDIT

        // if it is a lvl in mega menu
        if( $this->in_megamenu ){
            // if it is the direct lvl after mega menu item
            if( $depth == 0 ){
                $output .= "$indent\t</ul>\n";
                $output .= "$indent\t<!-- end mega column container -->\n\n";

                $output .= "$indent\t</li>\n";
                $output .= "$indent\t<!-- end mega row -->\n";
            } else {

            }

        }

        $output .= "$indent</ul>\n";
    }

    /**
     * Start the element output.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = str_repeat( "\t", $depth + 2 );

        $classes       = empty( $item->classes ) ? array()      : (array) $item->classes;
        $classes[]     = 'menu-item-' . $item->ID;
        $classes[]     = 'aux-menu-depth-' . $depth; //@EDIT


        if( ! isset( $args->menu ) ){
            return;
        }

        // Get the nav menu based on the requested menu
        $menu  = wp_get_nav_menu_object( $args->menu );

        // Get the nav menu based on the theme_location
        if ( ! $menu && $args->theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args->theme_location ] ) )
            $menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );

        // get the first menu that has items if we still can't find a menu
        if ( ! $menu && !$args->theme_location ) {
            $menus = wp_get_nav_menus();
            foreach ( $menus as $menu_maybe ) {
                if ( $menu_items = wp_get_nav_menu_items( $menu_maybe->term_id, array( 'update_post_term_cache' => false ) ) ) {
                    $menu = $menu_maybe;
                    break;
                }
            }
        }

        // check if the root element is megamenu
        if( 0 === $depth ){
            if( $this->in_megamenu      = get_post_meta( $item->ID, '_menu_item_megamenu', true ) ){
                $this->megamenu_col_num = get_post_meta( $item->ID, '_menu_item_col_num', true );
                $classes[] = 'aux-fullwidth-sub';
            }
            // add a class for specifying the index of root elements
            $classes[] = 'aux-menu-root-' . $this->root_menu_items_counter;
        }

        // Whether the submenu item is full or normal
        //@EDIT - start
        if( $this->in_megamenu && 1 == $depth ){
            $classes[] = 'aux-menu-column';
            $classes[] = 'aux-menu-list';
            // Add a grid class name for columns in the mega menu
            $classes[] = 'aux-col-1-' . $this->megamenu_col_num; // 'aux-col-1-4'
            // hide title for column
            if( $this->field_value( $item->ID, 'hide_title' ) ){
                $classes[] = 'aux-title-off';
            }

        } elseif( $this->in_megamenu && 2 == $depth ){
            $classes[] = 'aux-menu-item';
            $classes[] = 'aux-menu-list-item';

        } else {
            $classes[] = 'aux-menu-item';
        }

        if( $this->field_value( $item->ID, 'hide_desktop' ) ){
            $classes[] = 'aux-desktop-off';
        }
        if( $this->field_value( $item->ID, 'hide_tablet' ) ){
            $classes[] = 'aux-tablet-off';
        }
        if( $this->field_value( $item->ID, 'hide_mobile' ) ){
            $classes[] = 'aux-phone-off';
        }

        // add start submenu html comment
        if( $this->in_megamenu && 0 == $depth ){
            $output .= "\n$indent<!-- start megamenu -->";
            if( $depth > 0 ){ $output .= "\n"; } // better alignment for html comment

        // add start submenu html comment
        } elseif( $this->in_megamenu && 1 == $depth ){
            $output .= "\n$indent<!-- start mega column -->";
            if( $depth > 0 ){ $output .= "\n"; } // better alignment for html comment

            if ( $this->field_value( $item->ID, 'aux_background_image' ) ) {
                $classes[] = 'aux-menu-image-item';
                $attach_id = $this->field_value( $item->ID, 'aux_background_image' );
            }


        } elseif ( in_array( 'menu-item-has-children', $classes ) ){ //@Edit
            $output .= "\n$indent<!-- start submenu -->";
            if( $depth > 0 ){ $output .= "\n"; } // better alignment for html comment

        } elseif( 0 == $depth ) {
            $output .= "$indent<!-- start single menu -->";
        }
        //@EDIT - end

        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );


        $attr_classes = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filter the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        if( ! $depth ){ $output .= "\n"; } //@Edit

        $item_output = '';
        $output .= $indent . '<li' . $id . $attr_classes .'>'; //@Edit attr_classes


        /* generating markup for [menu item content]
        ======================================================================*/

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        // A class for link menu item content - on link tag
        $atts['class']  = 'aux-item-content'; // @EDIT

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        // whether to disable link on content or not
        $disable_link = $this->field_value( $item->ID, 'nolink' );

        // get link path for page types
        $link_path    = $this->field_value( $item->ID, 'link_path' );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            // dont generate href if link should be disabled
            if( $disable_link && 'href' === $attr ){
                continue;
            }
            if( ! empty( $link_path ) && 'href' === $attr ){
                $value = trailingslashit( $value ) . $link_path;
            }
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $icon_align    = $this->field_value( $item->ID, 'icon_align' );
        $icon_name     = $this->field_value( $item->ID, 'icon'       );
        $hide_label    = $this->field_value( $item->ID, 'hide_label' );
        $sec_text      = $this->field_value( $item->ID, 'sec_text' );
        $indent_child  = str_repeat( "\t", $depth + 2 );
        $item_output   = $args->before;
        $item_output  .= $indent_child .'<a'. $attributes .'>';


        // in this case we are expected to create {aux-menu-list-item} instead of {aux-item-content}
        // if( $this->in_megamenu && 2 == $depth ){

        $item_title   = apply_filters( 'the_title', $item->title, $item->ID );
        $item_desc    = $item->description ? $item->description : '';

        $item_content_tag = $disable_link ? 'div' : 'a';

        /** This filter is documented in wp-includes/post-template.php */
        $indent_child = str_repeat( "\t", $depth + 3 );

        $item_output  = $args->before;
        $item_output .= $indent_child .'<' . $item_content_tag . $attributes .'>';
        $item_output .= $args->link_before;

        $item_icon    = $icon_name ? "\n" . $indent_child . "\t" . sprintf( '<span class="aux-menu-icon %s %s"></span>', $icon_name, $icon_align ) : '';

        $item_content = '';
        if( ! $hide_label ){
            $item_content .= "\n" . $indent_child . "\t" . sprintf( '<span class="aux-menu-label">%s</span>', $item_title );
        }
        if( ! empty( $item_desc ) ){
            $item_content .= "\n" . $indent_child . "\t" . sprintf( '<span class="aux-menu-desc">%s</span>' , $item_desc );
        }

        if( ! empty( $sec_text ) ){
            $sec_text_color = $this->field_value( $item->ID, 'sec_bg_color' );
            $sec_text_color = ! empty( $sec_text_color ) ? 'style="background-color:' . esc_attr( $sec_text_color )  . '"' : '';
            $item_content .= "\n" . $indent_child . "\t" . sprintf( '<span class="aux-menu-sec-text" %s >%s</span>', $sec_text_color, $sec_text );
        }

        if( 'bottom' == $icon_align || 'right' == $icon_align ){
            $item_output .= $item_content . $item_icon;
        } else {
            $item_output .= $item_icon . $item_content;
        }

        $item_output .=  $args->link_after; //@EDIT
        $item_output .= "\n$indent_child</" . $item_content_tag . ">";//@EDIT
        $item_output .= $args->after;

        if ( ! empty( $attach_id )  && is_numeric( $attach_id ) ) {

            $image = auxin_get_the_responsive_attachment( $attach_id,
                array(
                    'quality'         => 100,
                    'preloadable'     => false,
                    'preload_preview' => false,
                    'size'            => 'full',
                    'crop'            => true,
                    'add_hw'          => true,
                    'upscale'         => false,
                    'original_src'    => true,
                )
            );

            $item_output .= $image ;
        }



        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of {@see wp_nav_menu()} arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $indent  = str_repeat( "\t", $depth + 2 );
        $output .= "$indent</li>\n";

        if( is_string( $item->classes ) ){
            $item->classes = array( $item->classes );
        }

        // add end submenu html comment
        if( $this->in_megamenu && 0 == $depth ){
            $output .= "$indent<!-- end megamenu -->\n";

        // add end submenu html comment
        } elseif( $this->in_megamenu && 1 == $depth ){
            $output .= "$indent<!-- end mega column -->\n";

        } elseif ( in_array( 'menu-item-has-children', $item->classes ) ){ //@Edit
            $output .= "$indent<!-- end submenu -->\n";

        } elseif( 0 == $depth ) {
            $output .= "$indent<!-- end single menu -->\n";
        }

        if( 0 == $depth ){
            // whether to add logo spacer in middle of root elements or not
            if( $this->has_logo_spacer_in_middle && floor( (int) $this->root_menu_items_num / 2 ) == $this->root_menu_items_counter ){
                $logo_width = auxin_get_option( "header_logo_width", 100 );
                $logo_width_style = "width: ". esc_attr( $logo_width ) . "px";
                $output .= "\n$indent<li class=\"menu-item aux-menu-depth-0 aux-menu-item aux-menu-item-spacer\"><span class=\"aux-item-content\" style=\"$logo_width_style\"></span></li>\n";
                $output .= "$indent<!-- end menu spacer -->\n";
            }
            $this->root_menu_items_counter++;
        }

    }


    public function field_value( $item_id, $field_name ){
        return get_post_meta( $item_id, '_menu_item_' . $field_name, true );
    }

}