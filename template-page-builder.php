<?php
/**
 * Template Name: Page Builder
 */
get_header();
?>

    <main id="primary" class="site-main">


        <?php


        if (have_rows('page_builder')):

            // Loop through rows.
            while (have_rows('page_builder')) : the_row();

                // Case: Homepage Hero
                if (get_row_layout() == 'hero_block'):
                    get_template_part('template-parts/hero-block');

                // Case: Intro Section
                elseif (get_row_layout() == 'categories_grid'):
                    get_template_part('template-parts/categories-grid');

                // Case: Grid Column
                elseif (get_row_layout() == 'social_proof_logos'):
                    get_template_part('template-parts/social-proof-logos');

                // Case: Half Half Section
                elseif (get_row_layout() == 'insurer_review_web'):
                    get_template_part('template-parts/insurer-review-web');

                // Case: Location
                elseif (get_row_layout() == 'insurance_by_state'):
                    get_template_part('template-parts/insurance-by-state');

                // Case: CTA Block
                elseif (get_row_layout() == 'latest_posts'):
                    get_template_part('template-parts/latest-posts');

                // Case: CTA Block
                elseif (get_row_layout() == 'expanders'):
                    get_template_part('template-parts/expander');

                // Case: Testimonials
                elseif (get_row_layout() == 'testimonials'):
                    get_template_part('template-parts/testimonials');

                // Case: Blog Posts
                elseif (get_row_layout() == 'blog_posts'):
                    get_template_part('template-parts/blog-posts');

                // Case: Page Hero
                elseif (get_row_layout() == 'page_hero'):
                    get_template_part('template-parts/page-hero');

                // Case: Image with Text
                elseif (get_row_layout() == 'image_with_text'):
                    get_template_part('template-parts/image-with-text');

                // Case: Gallery
                elseif (get_row_layout() == 'gallery'):
                    get_template_part('template-parts/gallery');

                // Case: Simple Text
                elseif (get_row_layout() == 'simple_text'):
                    get_template_part('template-parts/simple-text');

                // Case: Contact Form
                elseif (get_row_layout() == 'contact_form'):
                    get_template_part('template-parts/contact-form');

                // Case: Links
                elseif (get_row_layout() == 'links'):
                    get_template_part('template-parts/links');

                // Case: Social Icons
                elseif (get_row_layout() == 'social_icons'):
                    get_template_part('template-parts/social-icons');


                endif;

                // End loop.
            endwhile;
        else :
            // Do something...
        endif;


        ?>

    </main><!-- #main -->

<?php
get_footer();
