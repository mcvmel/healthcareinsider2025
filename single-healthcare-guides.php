<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package healthcareinsider2025
 */

$heading = get_sub_field('heading');
$text = get_sub_field('text');
$disclaimer = get_field('disclaimer');

$post_id = get_queried_object_id();
$url = get_permalink($post_id);
$title = wp_strip_all_tags(get_the_title($post_id));
$image = get_the_post_thumbnail_url($post_id, 'full');

// encode
$u = rawurlencode($url);
$t = rawurlencode($title);
$i = $image ? rawurlencode($image) : '';

get_header();
?>

    <main id="primary" class="site-main">

        <section class="single-hero single-hero--search-results">
            <div class="container">
                <div class="single-hero__inner">
                    <div class="single-hero__inner__bread-crumbs">
                        <img src="<?php echo get_template_directory_uri(); ?>/static/images/left-caret.png"
                             alt="left caret"><a href="/category/healthcare-guides/">Back To Healthcare Guides</a>
                    </div>
                    <h1 class="h2"><?php the_title(); ?></h1>

                </div>
            </div>
        </section>

        <section class="single-content-container">
            <div class="container">
                <div class="single-content">
                    <div class="single-content__filter">
                        <span class="small-heading">In This Guide</span>
                        <ul id="HealthGuideFilterUl" class="single-content__filter__ul" data-simplebar
                            data-simplebar-auto-hide="false">
                            <li></li>
                        </ul>
                        <div class="single-content__filter__download">
                            <span class="small-heading">Free Downloadable Guide</span>
                            <?php echo do_shortcode('[gravityform id="8" title="false"]'); ?>
                        </div>

                    </div>

                    <div class="single-content__post-content">

                        <?php if (have_rows('section_blocks')) : ?>
                            <?php while (have_rows('section_blocks')) : the_row();
                                $heading = get_sub_field('heading');
                                $text = get_sub_field('text'); ?>
                                <article class="guide-section">
                                    <?php if ($heading) : ?>
                                        <div class="guide-section__heading">
                                            <?php echo wp_kses_post($heading); ?>
                                            <button class="js-open-guide-section"></button>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($text) : ?>
                                        <div class="guide-section__text"><?php echo wp_kses_post($text); ?></div>
                                    <?php endif; ?>
                                </article>
                            <?php endwhile; ?>
                        <?php endif; ?>


                        <?php if (!empty($disclaimer)) : ?>
                            <div class="single-content__post-content__disclaimer">
                                <?php echo $disclaimer; ?>
                            </div>
                        <?php endif; ?>


                        <hr>


                        <section class="single-content__post-content__share">
                            <span class="single-content__post-content__share__label">Share:</span>

                            <a class="single-content__post-content__share__link"
                               href="<?php echo esc_url("https://www.facebook.com/sharer/sharer.php?u={$u}"); ?>"
                               onclick="window.open(this.href,'sharer','width=600,height=500');return false;"
                               rel="noopener"><img
                                    src="<?php echo esc_url(get_template_directory_uri() . '/static/images/facebook-icon-blue.png'); ?>"
                                    alt="Facebook"></a>

                            <a class="single-content__post-content__share__link"
                               href="<?php echo esc_url("https://twitter.com/intent/tweet?text={$t}&url={$u}"); ?>"
                               onclick="window.open(this.href,'sharer','width=600,height=500');return false;"
                               rel="noopener"><img
                                    src="<?php echo esc_url(get_template_directory_uri() . '/static/images/twitter-icon-blue.png'); ?>"
                                    alt="Twitter"></a>

                            <a class="single-content__post-content__share__link"
                               href="<?php echo esc_url("https://www.linkedin.com/sharing/share-offsite/?url={$u}"); ?>"
                               onclick="window.open(this.href,'sharer','width=600,height=500');return false;"
                               rel="noopener"><img
                                    src="<?php echo esc_url(get_template_directory_uri() . '/static/images/linkedin-icon-blue.png'); ?>"
                                    alt="Linkedin"></a>

                        </section>

                        <section class="single-content__post-content__feedback h2">
                            <span
                                class="single-content__post-content__feedback__heading">Was this article helpful?</span>
                            <div class="single-content__post-content__feedback__rating">
                                <img
                                    src="<?php echo esc_url(get_template_directory_uri() . '/static/images/thumbs-up.png'); ?>"
                                    alt="Yes" class="js-feedback-helpful-yes">
                                <img
                                    src="<?php echo esc_url(get_template_directory_uri() . '/static/images/thumbs-down.png'); ?>"
                                    alt="No" class="js-feedback-helpful-no">
                            </div>
                            <div class="single-content__post-content__feedback__form">
                                placeholder
                            </div>
                            <div class="single-content__post-content__feedback__thank-you">
                                <p>Thank you for your feedback!</p>
                            </div>
                        </section>


                    </div>
                </div>
            </div>
        </section>


    </main><!-- #main -->

<?php
get_footer();
