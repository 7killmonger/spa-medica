<?php $pages = get_pages(); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body>
    <?php wp_body_open(); ?>
    
    <header class="bg-transparent lg:bg-white lg:shadow container mx-auto px-4 sm:px-6 lg:px-8 rounded-2xl w-[90%] mt-10 top-0 left-0 right-0 fixed z-50">
        <nav x-data="{ open: false }" class="relative flex items-center justify-between h-20">
            <!-- Mobile Logo (Centered) -->
            <div class="flex-1 flex justify-center lg:hidden">
                <?php spa_medica_display_mobile_logo(); ?>
            </div>
            
            <!-- Desktop Navigation (Left) -->
            <div class="hidden lg:flex items-center flex-1">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex space-x-4',
                    'fallback_cb'    => false,
                    'walker'         => new Spa_Medica_Menu_Walker(),
                ));
                ?>
            </div>
            
            <!-- Desktop Logo (Right) -->
            <div class="hidden lg:flex items-center justify-end flex-1">
                <?php spa_medica_display_logo(); ?>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="lg:hidden absolute right-2">
                <button @click="open = !open" class="flex items-center p-2 rounded-md text-gray-800 hover:text-[#7DAB4E] focus:outline-none">
                    <span class="sr-only">Open main menu</span>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/svg/hamburger.svg" alt="Menu" class="h-6 w-6">
                </button>
            </div>
            
            <!-- Mobile Navigation Menu -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-1" 
                 class="absolute top-full right-0 left-0 bg-white shadow-md rounded-xl mt-2 py-4 w-full z-50"
                 @click.away="open = false">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'px-6 py-2 space-y-3',
                    'fallback_cb'    => false,
                    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'walker'         => new Spa_Medica_Mobile_Menu_Walker(),
                ));
                ?>
                <div class="w-[90%] mx-auto px-4 border-t border-gray-200 my-4"></div>
                <div class="flex justify-center items-center gap-8 py-2">
                    <a href="#" class="w-5 h-5 flex items-center justify-center">
                        <?php echo file_get_contents(get_template_directory() .'/assets/svg/twitter.svg'); ?>
                    </a>
                    <a href="#" class="w-5 h-5 flex items-center justify-center">
                        <?php echo file_get_contents(get_template_directory() .'/assets/svg/facebook.svg'); ?>
                    </a>
                    <a href="#" class="w-5 h-5 flex items-center justify-center">
                        <?php echo file_get_contents(get_template_directory() .'/assets/svg/instagram.svg'); ?>
                    </a>
                </div>
                <div class="flex justify-center items-center py-4 mt-8">
                    <a href="tel:+381600000000" class="text-white bg-[#7DAB4E] px-4 py-2 rounded-full hover:text-[#7DAB4E] hover:bg-white hover:border hover:border-[#7DAB4E] transition-colors flex items-center">
                        Zakazite tretman
                    </a>
                </div>
            </div>
        </nav>
    </header>




