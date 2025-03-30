<?php
/**
 * Template Name: Home Page with Hero
 * 
 * A custom template for the homepage with a hero section
 */

get_header();
?>

<section class="hero-section min-h-[85vh] py-20 md:py-32 bg-cover bg-center relative flex items-end z-10" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/hero.png');">
    <article class="container mx-auto px-4">
        <p class="text-white lg:text-3xl text-xl font-normal">Prednosti</p>
        <p class="text-white lg:text-8xl text-3xl font-normal font-dm-sans">FIZIKALNE MEDICINE</p>
    </article>
</section>

<section class="terapije relative mb-12">
    <article class="flex flex-col flex-wrap lg:max-h-[800px] lg:mt-[-20px] lg:rounded-t-3xl z-20 relative overflow-hidden shadow-lg">
            <?php
            // Custom query to get home-therapy posts
            $args = array(
                'post_type' => 'home-therapy',
                'posts_per_page' => -1,
            );
            
            $therapy_query = new WP_Query($args);
            
            if ($therapy_query->have_posts()) :
                while ($therapy_query->have_posts()) : $therapy_query->the_post();
                    // Get ACF fields
                    $title = get_field('title');
                    $desc = get_field('desc');
                    $link = get_field('link');
                    $img = get_field('img');
                    
                    // If img is empty, use default
                    if (empty($img)) {
                        // Create image path from title (lowercase and replace spaces with dashes)
                        $default_img = strtolower(str_replace(' ', '-', $title));
                        $img = get_template_directory_uri() . '/assets/img/' . $default_img . '.png';
                    }
                    
                    // Define flex direction based on alternating pattern
                    $card_index = $therapy_query->current_post;
                    $flex_direction = ($card_index % 2 == 0) ? 'lg:flex-row' : 'lg:flex-row-reverse';
                    ?>
                    
                    <div class="therapy-card flex flex-col overflow-hidden lg:w-[50%] h-[35rem] lg:h-[25rem] <?php echo $flex_direction; ?>">
                        <div class="lg:w-[50%] w-full lg:h-full h-[50%]">
                            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover">
                        </div>
                        <div class="lg:w-[50%] w-full lg:h-full h-[50%] flex flex-col justify-center items-center px-6 bg-white">
                            <h3 class="text-xl font-bold mb-2"><?php echo esc_html($title); ?></h3>
                            <p class="text-gray-700 mb-4 text-center"><?php echo esc_html($desc); ?></p>
                            <?php if ($link) : ?>
                                <a href="<?php echo esc_url($link); ?>" class="flex flex-col items-center text-gray-800 text-sm  hover:text-[#7DAB4E] transition-colors">
                                    <p class="text-gray-800 text-sm  hover:text-[#7DAB4E] transition-colors py-2">POGLEDAJ VIŠE</p>
                                    <div class="border-t border-gray-800 w-[60%]"></div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<div class="col-span-full text-center p-8">No therapy treatments found.</div>';
            endif;
            ?>
        
    </article>
</section>


<section class="nas-tim container mx-auto px-4 lg:mt-[10rem] mt-[5rem]">
    <div class="mb-[10rem] lg:hidden">
        <h2 class="text-center text-3xl ">Naš tim</h2>
    </div>
    <article class="flex flex-col-reverse lg:flex-row justify-between h-[20rem] relative bg-gradient-to-r from-[#EAFDD7] to-transparent px-10 rounded-3xl">
        <div class="self-center hidden lg:block">
            <h2 class="text-5xl font-bold">Upoznajte naš tim</h2>
            <p class="text-lg mt-4">Dr Igor Mandić</p>
            <p class="text-lg">Specijalista ortopedske hirurgije</p>
        </div>
        <div class="lg:w-[25%] sm:w-[50%] w-full xl:self-end lg:self-end self-center">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/dr-igor-mandic.png" alt="Dr Igor Mandić" class="w-full h-full object-fit">
        </div>
    </article>
    <div class="self-center lg:hidden container mx-auto px-4">
            <p class="text-lg font-bold mt-4">Dr Igor Mandić</p>
            <p class="text-lg">Specijalista ortopedske hirurgije</p>
        </div>

    <article class="flex flex-wrap gap-8 mt-12">
        <?php
        // Custom query to get our-team posts
        $args = array(
            'post_type' => 'our-team',
            'posts_per_page' => -1,
        );
        
        $team_query = new WP_Query($args);
        
        if ($team_query->have_posts()) :
            while ($team_query->have_posts()) : $team_query->the_post();
                // Get ACF fields
                $ime = get_field('ime');
                $zvanje = get_field('zvanje');
                $slika = get_field('slika');
                
                // If slika is empty, use default
                if (empty($slika)) {
                    $slika = get_template_directory_uri() . '/assets/img/doctor.jpg';
                }
                ?>
                
                <div class="team-card w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.5rem)] bg-white rounded-lg overflow-hidden">
                    <div class="overflow-hidden rounded-xl">
                        <img src="<?php echo esc_url($slika); ?>" alt="<?php echo esc_attr($ime); ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl mb-1"><?php echo esc_html($ime); ?></h3>
                        <p class="text-gray-600"><?php echo esc_html($zvanje); ?></p>
                    </div>
                </div>
                
            <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<div class="w-full text-center p-8">No team members found.</div>';
        endif;
        ?>
    </article>
</section>

<section class="container mx-auto px-4 py-16">
    <div class="swiper icons-swiper mx-auto">
        <div class="swiper-wrapper">
            <?php
            // Custom query to get home-therapy posts
            $args = array(
                'post_type' => 'home-therapy',
                'posts_per_page' => -1,
            );
            
            $therapy_query = new WP_Query($args);
            
            if ($therapy_query->have_posts()) :
                while ($therapy_query->have_posts()) : $therapy_query->the_post();
                    // Get ACF fields
                    $title = get_field('title');
                    $icon = get_field('icon'); // Assuming there's an 'icon' field in your ACF setup
                    
                    // If icon is empty, use default
                    if (empty($icon)) {
                        $icon = get_template_directory_uri() . '/assets/img/icon.png';
                    }
                    ?>
                    
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center text-center group p-12 shadow-md rounded-3xl lg:bg-white bg-[#EAFCD7] hover:bg-[#EAFCD7] transition-all duration-300 h-full">
                            <div class="w-[5.6rem] h-[5.6rem] mb-4 lg:transition-all lg:duration-300 lg:grayscale lg:filter lg:group-hover:grayscale-0">
                                <img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-contain">
                            </div>
                            <h3 class="text-base font-medium"><?php echo esc_html($title); ?></h3>
                        </div>
                    </div>
                    
                <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
        <!-- Add pagination -->
        <!-- <div class="swiper-pagination"></div> -->
        <!-- Add navigation buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>

<section class="nasa-lookacija container mx-auto lg:px-4 px-0 ">
    <article class="flex flex-col lg:flex-row">
        <div class="lg:w-[50%] container mx-auto px-4 py-14 flex flex-col justify-between">
            <h2 class="lg:text-6xl text-4xl">Naša adresa</h2> 
            <p>Orthopedic dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since</p>
            <a href="#" class="text-white bg-[#7DAB4E] px-4 py-2 rounded-full w-[50%] text-center lg:block hidden">POGLEDAJTE CJENOVNIK</a>
        </div>
        <div class="lg:w-[50%]">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2944.7048503559427!2d19.24300787630264!3d42.43401693042574!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x134deb22935523b5%3A0x6246b0b0e4139adb!2sSpa%20Medica!5e0!3m2!1sen!2s!4v1743356611976!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-full"></iframe>
            <a href="#" class="text-white bg-[#7DAB4E] px-4 py-2 rounded-full text-center w-[80%] mx-auto lg:hidden block mt-8">POGLEDAJTE CJENOVNIK</a>
        </div>
        
    </article>

</section>
<?php
get_footer(); 