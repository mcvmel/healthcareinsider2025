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


                if (get_row_layout() == 'hero_block'):
                    get_template_part('template-parts/hero-block');


                elseif (get_row_layout() == 'categories_grid'):
                    get_template_part('template-parts/categories-grid');


                elseif (get_row_layout() == 'social_proof_logos'):
                    get_template_part('template-parts/social-proof-logos');

                elseif (get_row_layout() == 'insurer_review_web'):
                    get_template_part('template-parts/insurer-review-web');

                elseif (get_row_layout() == 'insurance_by_state'):
                    get_template_part('template-parts/insurance-by-state');

                elseif (get_row_layout() == 'latest_posts'):
                    get_template_part('template-parts/latest-posts');

                elseif (get_row_layout() == 'image_with_text'):
                    get_template_part('template-parts/image-with-text');

                elseif (get_row_layout() == 'author_callout'):
                    get_template_part('template-parts/author-callout');

                elseif (get_row_layout() == 'health_insurance_state_directory'):
                    get_template_part('template-parts/health-insurance-state-directory');

                elseif (get_row_layout() == 'values'):
                    get_template_part('template-parts/values');

                elseif (get_row_layout() == 'author_grid'):
                    get_template_part('template-parts/author-grid');

                elseif (get_row_layout() == 'reviewer_grid'):
                    get_template_part('template-parts/reviewer-grid');


                elseif (get_row_layout() == 'simple_cta'):
                    get_template_part('template-parts/simple-cta');



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
