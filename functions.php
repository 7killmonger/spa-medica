<?php
/**
 * Spa Medica Theme Functions
 */

// Theme setup function
function spa_medica_setup() {
    // Add custom logo support
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'spa-medica'),
        'footer' => esc_html__('Footer Menu', 'spa-medica'),
    ));
}
add_action('after_setup_theme', 'spa_medica_setup');

function spa_medica_scripts() {
    wp_enqueue_style('spa-medica-tailwind', get_template_directory_uri() . '/dist/css/tailwind.css', array(), '1.0.0');
    
    // Add Swiper CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');
    
    wp_enqueue_style('spa-medica-style', get_stylesheet_uri(), array('spa-medica-tailwind'), '1.0.0');
    
    // Add Alpine.js from CDN
    wp_enqueue_script('alpine-js', 'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js', array(), '3.0.0', true);
    wp_script_add_data('alpine-js', 'defer', true);
    
    // Add Swiper JS
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);
    
    // Add custom JS file for initializing Swiper
    wp_enqueue_script('spa-medica-js', get_template_directory_uri() . '/js/main.js', array('swiper-js'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'spa_medica_scripts');

/**
 * Custom logo helper function
 * Use this to display the logo with fallback to site title
 */
function spa_medica_display_logo() {
    if (has_custom_logo()) {
        the_custom_logo();
    } else if (file_exists(get_template_directory() . '/assets/img/logo.png')) {
        echo '<a href="' . esc_url(home_url('/')) . '" class="custom-logo-link" rel="home">';
        echo '<img src="' . get_template_directory_uri() . '/assets/svg/logo.svg" alt="' . get_bloginfo('name') . '" class="custom-logo">';
        echo '</a>';
    } else {
        echo '<h1 class="site-title text-2xl font-bold"><a href="' . esc_url(home_url('/')) . '" class="text-primary hover:text-secondary transition-colors">' . get_bloginfo('name') . '</a></h1>';
        
        $description = get_bloginfo('description', 'display');
        if ($description || is_customize_preview()) {
            echo '<p class="site-description text-sm text-gray-600">' . $description . '</p>';
        }
    }
}

/**
 * Mobile logo helper function
 * Use this to display the mobile logo
 */
function spa_medica_display_mobile_logo() {
    if (has_custom_logo()) {
        // If there's a custom logo set in customizer but we want to override it for mobile
        echo '<a href="' . esc_url(home_url('/')) . '" class="custom-logo-link" rel="home">';
        echo '<img src="' . get_template_directory_uri() . '/assets/svg/mobile-log.svg" alt="' . get_bloginfo('name') . '" class="custom-logo mobile-logo">';
        echo '</a>';
    } else if (file_exists(get_template_directory() . '/assets/svg/mobile-log.svg')) {
        echo '<a href="' . esc_url(home_url('/')) . '" class="custom-logo-link" rel="home">';
        echo '<img src="' . get_template_directory_uri() . '/assets/svg/mobile-log.svg" alt="' . get_bloginfo('name') . '" class="custom-logo mobile-logo">';
        echo '</a>';
    } else {
        // Fallback to text if no mobile logo
        echo '<h1 class="site-title text-xl font-bold"><a href="' . esc_url(home_url('/')) . '" class="text-primary hover:text-secondary transition-colors">' . get_bloginfo('name') . '</a></h1>';
    }
}

/**
 * Custom Walker Class for Navigation Menus
 */
class Spa_Medica_Menu_Walker extends Walker_Nav_Menu {
    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        // Check if this item has children
        $has_children = in_array('menu-item-has-children', $classes);
        
        // Common classes for all menu items
        $item_classes = 'transition-colors duration-300';
        
        if ($depth === 0) {
            // Top level items
            $item_classes .= ' relative group px-2 py-2 lg:py-6 text-gray-800 hover:text-[#7DAB4E]';
        } else {
            // Sub menu items - individual hover only, not inherited from parent
            $item_classes .= ' w-full text-sm py-3 px-4 text-gray-800 hover:bg-gray-100 hover:text-[#7DAB4E]';
        }
        
        // Add active class
        if (in_array('current-menu-item', $classes)) {
            $item_classes .= ' text-[#7DAB4E]';
        }
        
        $output .= '<li class="' . esc_attr($item_classes) . '">';
        
        $atts = array();
        $atts['href'] = !empty($item->url) ? $item->url : '';
        
        if ($depth === 0) {
            $atts['class'] = 'text-current';
        } else {
            $atts['class'] = 'text-gray-800 hover:text-[#7DAB4E]';
        }
        
        if ($has_children && $depth === 0) {
            $atts['class'] .= ' flex items-center';
        }
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        
        // Add dropdown arrow for parent items
        if ($has_children && $depth === 0) {
            $item_output .= '<svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>';
        }
        
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            // First level submenu - ensure items don't inherit parent hover color
            $output .= '<ul class="absolute left-0 mt-0 w-48 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-10 text-gray-800">';
        } else {
            // Nested submenus (if needed)
            $output .= '<ul class="pl-4">';
        }
    }
}

/**
 * Custom Walker Class for Mobile Navigation Menu
 */
class Spa_Medica_Mobile_Menu_Walker extends Walker_Nav_Menu {
    // Track the current parent item
    private $current_parent_item = null;
    
    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        // Check if this item has children
        $has_children = in_array('menu-item-has-children', $classes);
        
        // Base classes for all menu items
        $item_classes = 'block w-full text-left';
        
        if ($depth === 0) {
            // Top level items
            $item_classes .= ' py-2 hover:text-[#7DAB4E] text-[24px] font-bold text-[#52525B]';
            
            if ($has_children) {
                // If it has children, make it use Alpine.js toggle
                $item_classes .= ' relative';
            }
        } else {
            // Sub menu items
            $item_classes .= ' py-2 pl-4 text-sm text-gray-700 hover:text-[#7DAB4E] hover:bg-gray-50';
        }
        
        // Add active class
        if (in_array('current-menu-item', $classes)) {
            $item_classes .= ' text-[#7DAB4E]';
        }
        
        $item_id = 'mobile-menu-item-' . $item->ID;
        
        if ($has_children && $depth === 0) {
            // Parent item with submenu using Alpine.js for toggle
            $output .= '<li class="' . esc_attr($item_classes) . '" x-data="{ open: false }">';
            
            // Store the current parent item data for use in start_lvl
            $this->current_parent_item = array(
                'url' => !empty($item->url) ? $item->url : '#',
                'title' => apply_filters('the_title', $item->title, $item->ID)
            );
            
            // Create the toggle div instead of a link (no navigation)
            $item_output = $args->before;
            $item_output .= '<div class="flex items-center justify-between w-full cursor-pointer" @click="open = !open">';
            $item_output .= '<span class="block py-2 text-[24px] font-bold text-[#52525B] hover:text-[#7DAB4E]">' . $args->link_before . $this->current_parent_item['title'] . $args->link_after . '</span>';
            
            // Add toggle button
            $item_output .= '<span class="p-1">';
            $item_output .= '<svg class="w-5 h-5 transition-transform" :class="{ \'rotate-180\': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>';
            $item_output .= '</span>';
            $item_output .= '</div>';
            $item_output .= $args->after;
        } else {
            // Regular item
            $output .= '<li class="' . esc_attr($item_classes) . '">';
            
            $atts = array();
            $atts['href'] = !empty($item->url) ? $item->url : '#';
            $atts['class'] = 'block w-full';
            
            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }
            
            $title = apply_filters('the_title', $item->title, $item->ID);
            
            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
        }
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            // First level submenu using Alpine.js to show/hide
            $output .= '<ul x-show="open" 
                          x-transition:enter="transition-all ease-in-out duration-300" 
                          x-transition:enter-start="opacity-0 max-h-0" 
                          x-transition:enter-end="opacity-100 max-h-96" 
                          x-transition:leave="transition-all ease-in-out duration-300" 
                          x-transition:leave-start="opacity-100 max-h-96" 
                          x-transition:leave-end="opacity-0 max-h-0" 
                          class="overflow-hidden ml-2 mt-1 border-l-2 border-gray-200">';
                          
            // Add "Sve" item (See all) for the parent item
            if (!empty($this->current_parent_item)) {
                $output .= '<li class="py-2 pl-4 text-sm font-semibold text-[#7DAB4E] ">';
                $output .= '<a href="' . esc_url($this->current_parent_item['url']) . '" class="block w-full flex items-center">';

                $output .= 'Sve ' . esc_html($this->current_parent_item['title']);
                $output .= '</a></li>';
            }
        } else {
            // Nested submenus
            $output .= '<ul class="ml-4">';
        }
    }
}





