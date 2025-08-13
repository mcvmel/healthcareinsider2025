<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package healthcareinsider2025
 */

get_header();
?>

    <main id="primary" class="site-main">

        <section class="single-hero">
            <div class="container">
                <div class="single-hero__inner" data-aos="fade">
                    <h1 class="h2"><?php the_title(); ?></h1>
                    <div class="single-hero__inner__meta">
						<p>Update on <?php echo get_the_modified_date('F j, Y'); ?></p>
                    </div>
                </div>
            </div>
        </section>


        <section class="page-content-container">
            <div class="container">
                <div class="page-content">
                    <div class="page-content__filter">
                        <ul id="SingleContentFilterUl" class="page-content__filter__ul" data-simplebar
                            data-simplebar-auto-hide="false">
                        </ul>
                    </div>

                    <div class="page-content__post-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </section>


    </main><!-- #main -->

<?php
get_footer();
