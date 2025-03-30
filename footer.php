
</body>
    <footer class="site-footer bg-transparent py-8 mt-12">
        <div class="w-full lg:hidden flex justify-center mb-8">
            <?php spa_medica_display_logo(); ?>
        </div>
        <div class="container mx-auto px-12 lg:px-4 flex justify-between felx ">
            <div class="flex-wrap justify-between flex-col hidden lg:flex">
                <div class="w-full md:w-auto mb-8 lg:flex hidden">
                    <?php spa_medica_display_logo(); ?>
                </div>
                <div class=" flex-wrap justify-between flex-col">
                    <p class="text-sm text-[#7DAB4E]">Radno vrijeme</p>
                    <p class="text-sm font-bold">Ponedjeljak - Petak:</p>
                    <p class="text-sm">08:00 - 16:00</p>
                </div>
            </div>
            <div class="flex flex-wrap justify-between flex-col">
                <p class="text-sm text-[#7DAB4E] font-bold mb-4">Stranice</p>
                <ul>
                    <?php
                    // Get all published pages, but only top-level ones
                    $pages = get_pages(array(
                        'sort_column' => 'menu_order,post_title',
                        'parent' => 0, // Only get top-level pages (no children)
                    ));
                    
                    // Loop through the pages
                    foreach ($pages as $page) {
                        echo '<li class="mb-2"><a href="' . get_permalink($page->ID) . '" class="text-xs text-[#52525B] hover:text-[#7DAB4E] transition-colors">' . 
                            $page->post_title . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="flex flex-wrap justify-between flex-col">
                <p class="text-sm text-[#7DAB4E] font-bold mb-4">Usluge</p>
                <ul>
                    <?php
                    // Find the "Usluge" page using WP_Query instead of deprecated get_page_by_title
                    $usluge_query = new WP_Query(array(
                        'post_type' => 'page',
                        'name' => sanitize_title('Usluge'),
                        'posts_per_page' => 1,
                    ));
                    
                    // If page doesn't exist with slug, try search by title
                    if (!$usluge_query->have_posts()) {
                        wp_reset_postdata();
                        $usluge_query = new WP_Query(array(
                            'post_type' => 'page',
                            'posts_per_page' => 1,
                            's' => 'Usluge',
                            'exact' => true
                        ));
                    }
                    
                    // If page exists, get its ID
                    $usluge_id = 0;
                    if ($usluge_query->have_posts()) {
                        $usluge_query->the_post();
                        $usluge_id = get_the_ID();
                        wp_reset_postdata();
                    }
                    
                    // If we found the page, get all its children
                    if ($usluge_id) {
                        $subpages = get_pages(array(
                            'child_of' => $usluge_id,
                            'sort_column' => 'menu_order,post_title',
                        ));
                        
                        // Loop through the subpages
                        foreach ($subpages as $subpage) {
                            echo '<li class="mb-2"><a href="' . get_permalink($subpage->ID) . '" class="text-xs text-[#52525B] hover:text-[#7DAB4E] transition-colors">' . 
                                $subpage->post_title . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="flex-wrap flex-col w-[30%] lg:flex hidden">
                <p class="text-sm text-[#7DAB4E] font-bold mb-6">newsletter</p>
                <form action="#" method="post">
                    <input type="email" name="email" placeholder="Vaša email adresa" class="w-full p-4 border border-[#7DAB4E] rounded-full mb-4">
                    <button type="submit" class="bg-[#7DAB4E] text-white  rounded-full w-full py-3 text-center">Prijavi se</button>
                </form>
            </div>
        </div>
        <div class="flex-wrap flex-col w-full container mx-auto lg:hidden flex justify-center mt-4">
                <p class="text-sm text-[#7DAB4E] font-bold mb-6 w-full text-center">newsletter</p>
                <form action="#" method="post">
                    <input type="email" name="email" placeholder="Vaša email adresa" class="w-full p-2 border border-[#7DAB4E] rounded-full mb-4">
                    <button type="submit" class="bg-[#7DAB4E] text-white  rounded-full w-full py-2 text-center">Prijavi se</button>
                </form>
            </div>
        <div class="flex justify-center lg:justify-start items-center gap-8 m-6 container mx-auto">
                <a href="#" class="w-5 h-5 flex items-center justify-center overflow-hidden">
                    <?php echo file_get_contents(get_template_directory() .'/assets/svg/twitter.svg'); ?>
                </a>
                <a href="#" class="w-5 h-5 flex items-center justify-center overflow-hidden">
                    <?php echo file_get_contents(get_template_directory() .'/assets/svg/facebook.svg'); ?>
                </a>
                <a href="#" class="w-5 h-5 flex items-center justify-center overflow-hidden">
                    <?php echo file_get_contents(get_template_directory() .'/assets/svg/instagram.svg'); ?>
                </a>
        </div>
        <div class="border-t w-full border-gray-200 py-2 container mx-auto"></div>
        <div class="container mx-auto px-4 flex items-center justify-between">
            <div class="flex-wrap justify-between w-[30%] hidden lg:flex">
                <p class="text-sm text-[#52525B]">about us</p>
                <p class="text-sm text-[#52525B]">about us</p>
                <p class="text-sm text-[#52525B]">about us</p>
                <p class="text-sm text-[#52525B]">about us</p>
            </div>
            <p class="text-sm text-[#52525B] text-center w-full lg:w-auto">© 2000-2021, All rights reserved</p>
        </div>
    </footer>

    <?php wp_footer(); ?>

</html>

