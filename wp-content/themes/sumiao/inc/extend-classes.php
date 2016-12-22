<?php

class SH_Nav_Menu_Walker extends Walker {
    // var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

    function start_lvl(&$output, $depth=0,$args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent";
        $output .= "<i class=\"dropdown icon\"></i>\n";
        $output .= "<ul class=\"sub-menu\">\n";
    }

    function end_lvl(&$output, $depth=0,$args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $item, $depth=0, $args=array(),$current_object_id=0) {
        $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes = in_array( 'current-menu-item', $classes ) ? array( 'current-menu-item' ) : array();
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = strlen( trim( $class_names ) ) > 0 ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id = apply_filters( 'nav_menu_item_id', '', $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        if (is_array($item->classes)) {
            $tClass = sizeof($item->classes);
            for($x = 0; $x < $tClass; $x++) {
                if ($x == 0) {
                    $iClass .= ' class="';
                }
                $iClass .= esc_attr($item->classes[$x]) . ' ';
                if ($x == $tClass -1) {
                    $iClass .= '"';
                }
            }
        }
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $item_output = $args->before;
        $item_output .= '<li ' . $iClass . '>';
        $item_output .= '<a'. $attributes . $id . $value . $class_names . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= "</a>\n";
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    function end_el(&$output, $object, $depth = 0, $args = Array()) {
    	$output .= '</li>';
    	$output .= apply_filters( 'walker_nav_menu_end_el', $item_output, $item, $depth, $args );
    }
}