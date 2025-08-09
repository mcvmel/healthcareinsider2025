<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package healthcareinsider2025
 */
$insurer_short_name = get_field('insurer_short_name');
$fact_checked = get_field('fact_checked');

$reviewed_by = get_field('reviewed_by');
$coverage_areas = get_field('coverage_areas');
$plan_types = get_field('plan_types');
$top_highlight = get_field('top_highlight');
$citations = get_field('citations');
$post_disclaimer = get_field('post_disclaimer', 'option');

// Author basics
$author_id   = (int) get_post_field('post_author', get_the_ID());
$author_name = get_the_author_meta('display_name', $author_id);

// ACF user fields
$author_headline   = get_field('user_headline',      'user_' . $author_id);
$author_large_bio  = get_field('user_large_bio',     'user_' . $author_id);
$author_fb         = get_field('user_facebook_url',  'user_' . $author_id);
$author_tw         = get_field('user_twitter_url',   'user_' . $author_id);
$author_ig         = get_field('user_instagram_url', 'user_' . $author_id);
$author_li         = get_field('user_linkedin_url',  'user_' . $author_id);
$author_www        = get_field('user_website_url',   'user_' . $author_id);

// Image (force raw to handle ID/array/URL consistently)
$author_image_raw = get_field('user_photo', 'user_' . $author_id, false);
$author_image_url = '';
$author_image_alt = $author_name;

// Normalize image to URL + ALT
if (is_numeric($author_image_raw)) {
    $author_image_url = wp_get_attachment_image_url((int)$author_image_raw, 'full');
    $author_image_alt = get_post_meta((int)$author_image_raw, '_wp_attachment_image_alt', true) ?: $author_name;
} elseif (is_array($author_image_raw) && !empty($author_image_raw['url'])) {
    $author_image_url = $author_image_raw['url'];
    $author_image_alt = !empty($author_image_raw['alt']) ? $author_image_raw['alt'] : $author_name;
} elseif (is_string($author_image_raw)) {
    $author_image_url = $author_image_raw;
}

// Final fallback (theme default, then Gravatar)
if (!$author_image_url) {
    $theme_fallback = get_template_directory_uri() . '/static/images/default-author.png';
    $grav_url = get_avatar_url($author_id, ['size' => 256]);
    $author_image_url = $grav_url ?: $theme_fallback;
}

$hci = get_field('hci_rating'); // returns array

$coverage_rating = isset($hci['coverage_breadth_accessibility_rating']) ? (float)$hci['coverage_breadth_accessibility_rating'] : null;
$variety_rating = isset($hci['plan_variety_customization_rating']) ? (float)$hci['plan_variety_customization_rating'] : null;
$afford_rating = isset($hci['affordability_value_rating']) ? (float)$hci['affordability_value_rating'] : null;
$innovation_rating = isset($hci['innovation_care_quality_rating']) ? (float)$hci['innovation_care_quality_rating'] : null;
$consumer_rating = isset($hci['consumer_experience_transparency_rating']) ? (float)$hci['consumer_experience_transparency_rating'] : null;

$coverage_note = isset($hci['coverage_breadth_accessibility_note']) ? $hci['coverage_breadth_accessibility_note'] : '';
$variety_note = isset($hci['plan_variety_customization_note']) ? $hci['plan_variety_customization_note'] : '';
$afford_note = isset($hci['affordability_value_note']) ? $hci['affordability_value_note'] : '';
$innovation_note = isset($hci['innovation_care_quality_note']) ? $hci['innovation_care_quality_note'] : '';
$consumer_note = isset($hci['consumer_experience_transparency_note']) ? $hci['consumer_experience_transparency_note'] : '';

// Average (1 decimal)
$valid = array_filter(
    [$coverage_rating, $variety_rating, $afford_rating, $innovation_rating, $consumer_rating],
    'is_numeric'
);
$overall = $valid ? round(array_sum($valid) / count($valid), 1) : null;



$post_id   = get_queried_object_id();
$url       = get_permalink($post_id);
$title     = wp_strip_all_tags(get_the_title($post_id));
$image     = get_the_post_thumbnail_url($post_id, 'full');

// encode
$u = rawurlencode($url);
$t = rawurlencode($title);
$i = $image ? rawurlencode($image) : '';

$categories = get_the_category();


$current_id = get_the_ID();

$args = [
    'post_type'           => 'post',
    'posts_per_page'      => 3,
    'post__not_in'        => [$current_id],
    'ignore_sticky_posts' => 1,
    'orderby'             => 'date',
    'order'               => 'DESC',
];

if (!empty($categories)) {
    $args['category__in'] = wp_list_pluck($categories, 'term_id');
} else {
    $args['category_name'] = 'insurer-reviews';
}

$related = new WP_Query($args);



get_header();
?>

    <main id="primary" class="site-main">

        <section class="single-hero">
            <div class="container">
                <div class="single-hero__inner">
                    <div class="single-hero__inner__bread-crumbs">
                        <?php

                        if (!empty($categories)) {
                            $category = $categories[0]; // Get first category
                            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">'
                                . esc_html($category->name) .
                                '</a>';
                        }
                        ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/static/images/right-caret.png"
                             alt="right caret">
                        <span><?php echo $insurer_short_name; ?></span>
                    </div>
                    <h1 class="h2"><?php the_title(); ?></h1>

                    <div class="single-hero__inner__meta">


                        <?php
                        $fact_checked = get_field('fact_checked');

                        if ($fact_checked === 'yes') { ?>
                            <img
                                src="<?php echo get_template_directory_uri(); ?>/static/images/hci-fact-checked-badge.png"
                                alt="Fact Checked"> by
                        <?php } ?>

                        <?php if (!empty($reviewed_by)) : ?>
                            <?php
                            // Handle both return formats: User ID or User Array
                            $user_id = is_array($reviewed_by) && isset($reviewed_by['ID']) ? $reviewed_by['ID'] : $reviewed_by;
                            // Grab user fields
                            $display_name = get_the_author_meta('display_name', $user_id);
                            ?>
                            <?php echo esc_html($display_name); ?>
                        <?php endif; ?>
                        | Update on
                        <?php
                        echo get_the_modified_date('F j, Y');
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="single-content-container">
            <div class="container">
                <div class="single-content">
                    <div class="single-content__filter">
                        <span class="small-heading">In This Article</span>
                        <ul id="SingleContentFilterUl" class="single-content__filter__ul" data-simplebar data-simplebar-auto-hide="false">

                        </ul>

                    </div>

                    <div class="single-content__post-content">

                        <section class="single-content__post-content__credits">
                            <div class="single-content__post-content__credits__column">

                                <div class="single-content__post-content__credits__column__user">

                                    <?php if ( ! empty( $author_image_url ) ) : ?>
                                        <img class="single-content__post-content__credits__column__user__photo"
                                             src="<?php echo esc_url( $author_image_url ); ?>"
                                             alt="<?php echo esc_attr( $author_image_alt ?: $author_name ); ?>">
                                    <?php else : ?>
                                        <img class="single-content__post-content__credits__column__user__photo"
                                             src="<?php echo esc_url(get_template_directory_uri() . '/static/images/default-author.png'); ?>"
                                             alt="<?php echo esc_html($author_name); ?>"/>
                                    <?php endif; ?>
                                    <div class="single-content__post-content__credits__column__user__info">
                                        <p>Written by <?php echo esc_html($author_name); ?></p>
                                        <?php if (!empty($author_headline)) : ?>
                                            <p><?php echo esc_html($author_headline); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <?php if (!empty($reviewed_by)) : ?>
                                <?php
                                $reviewer_id = is_array($reviewed_by) ? $reviewed_by['ID'] : $reviewed_by;
                                $reviewer_image = get_field('user_photo', 'user_' . $reviewer_id);
                                $reviewer_name = get_the_author_meta('display_name', $reviewer_id);
                                $reviewer_headline = get_field('user_headline', 'user_' . $reviewer_id);
                                ?>
                                <div class="single-content__post-content__credits__column">
                                    <div class="single-content__post-content__credits__column__user">
                                        <?php if (!empty($reviewer_image) && is_array($reviewer_image)) : ?>
                                            <img class="single-content__post-content__credits__column__user__photo"
                                                 src="<?php echo esc_url($reviewer_image['url']); ?>"
                                                 alt="<?php echo esc_html($reviewer_name); ?>">
                                        <?php else : ?>
                                            <img class="single-content__post-content__credits__column__user__photo"
                                                 src="<?php echo esc_url(get_template_directory_uri() . '/static/images/default-author.png'); ?>"
                                                 alt="<?php echo esc_attr($reviewer_image['alt'] ?: $reviewer_name); ?>"/>
                                        <?php endif; ?>
                                        <div class="single-content__post-content__credits__column__user__info">
                                            <p>Reviewed by <?php echo esc_html($reviewer_name); ?></p>
                                            <?php if (!empty($reviewer_headline)) : ?>
                                                <p><?php echo esc_html($reviewer_headline); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </section>

                        <?php if (!empty($post_disclaimer)) : ?>
                            <div class="single-content__post-content__disclaimer">
                                <?php echo $post_disclaimer; ?>
                            </div>
                        <?php endif; ?>

                        <section class="single-content__post-content__intro white-card white-card--no-hover">
                            <div class="single-content__post-content__intro__image">
                                <?php healthcareinsider2025_post_thumbnail(); ?>
                            </div>

                            <h2><?php the_title(); ?></h2>

                            <?php
                            $raw_excerpt = get_post_field('post_excerpt', get_the_ID(), 'raw');
                            if ($raw_excerpt) {
                                echo wpautop(wp_kses_post($raw_excerpt));
                            }
                            ?>

                            <span class="small-heading">Coverage Areas</span>
                            <?php echo $coverage_areas; ?>
                            <span class="small-heading">Plan Types</span>
                            <?php echo $plan_types; ?>



                        </section>

                        <section class="single-content__post-content__hci-rating">
                            <?php if ($overall !== null): ?>
                                <h4>HealthCare Insider Overall Rating: <?php echo esc_html($overall); ?>/10</h4>
                            <?php endif; ?>



                            <div class="single-content__post-content__hci-rating__list">
                                <div class="single-content__post-content__hci-rating__list__item">
        <span
            class="single-content__post-content__hci-rating__list__item__label">Coverage Breadth & Accessibility</span>
                                    <?php if ($coverage_rating !== null): ?>
                                        <span class="single-content__post-content__hci-rating__list__item__value"
                                              data-number="<?php echo esc_attr($coverage_rating); ?>"></span>
                                    <?php endif; ?>
                                    <?php if ($coverage_note): ?>
                                        <p class="single-content__post-content__hci-rating__list__item__note"><?php echo wp_kses_post($coverage_note); ?></p>
                                    <?php endif; ?>
                                </div>


                                <div class="single-content__post-content__hci-rating__list__item">
                                    <span class="single-content__post-content__hci-rating__list__item__label">Plan Variety & Customization</span>
                                    <?php if ($variety_rating !== null): ?>
                                        <span class="single-content__post-content__hci-rating__list__item__value"
                                              data-number="<?php echo esc_attr($variety_rating); ?>"></span>
                                    <?php endif; ?>

                                    <?php if ($variety_note): ?>
                                        <p class="single-content__post-content__hci-rating__list__item__note"><?php echo wp_kses_post($variety_note); ?></p>
                                    <?php endif; ?>

                                </div>


                                <div class="single-content__post-content__hci-rating__list__item">
                                    <span class="single-content__post-content__hci-rating__list__item__label">Affordability & Value</span>
                                    <?php if ($afford_rating !== null): ?>
                                        <span class="single-content__post-content__hci-rating__list__item__value"
                                              data-number="<?php echo esc_attr($afford_rating); ?>"></span>
                                    <?php endif; ?>

                                    <?php if ($afford_note): ?>
                                        <p class="single-content__post-content__hci-rating__list__item__note"><?php echo wp_kses_post($afford_note); ?></p>
                                    <?php endif; ?>

                                </div>


                                <div class="single-content__post-content__hci-rating__list__item">
                                    <span class="single-content__post-content__hci-rating__list__item__label">Innovation & Care Quality</span>
                                    <?php if ($innovation_rating !== null): ?>
                                        <span class="single-content__post-content__hci-rating__list__item__value"
                                              data-number="<?php echo esc_attr($innovation_rating); ?>"></span>
                                    <?php endif; ?>

                                    <?php if ($innovation_note): ?>
                                        <p class="single-content__post-content__hci-rating__list__item__note"><?php echo wp_kses_post($innovation_note); ?></p>
                                    <?php endif; ?>
                                </div>


                                <div class="single-content__post-content__hci-rating__list__item">
        <span
            class="single-content__post-content__hci-rating__list__item__label">Consumer Experience & Transparency</span>
                                    <?php if ($consumer_rating !== null): ?>
                                        <span class="single-content__post-content__hci-rating__list__item__value"
                                              data-number="<?php echo esc_attr($consumer_rating); ?>"></span>
                                    <?php endif; ?>

                                    <?php if ($consumer_note): ?>
                                        <p class="single-content__post-content__hci-rating__list__item__note"><?php echo wp_kses_post($consumer_note); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>


                        </section>

                        <section class="single-content__post-content__top-highlight">
                            <?php echo $top_highlight ?>
                        </section>

                        <?php
                        while (have_posts()) :
                            the_post();

                            get_template_part('template-parts/content', get_post_type());

                        endwhile; // End of the loop.
                        ?>

                        <section class="single-content__post-content__bottom-author">
                            <div class="single-content__post-content__bottom-author__left">

                                <div class="single-content__post-content__bottom-author__left__photo">
                                    <?php if ( ! empty( $author_image_url ) ) : ?>
                                        <img src="<?php echo esc_url( $author_image_url ); ?>" alt="<?php echo esc_attr( $author_image_alt ?: $author_name ); ?>">
                                    <?php else : ?>
                                        <img src="<?php echo esc_url( get_template_directory_uri() . '/static/images/default-author.png' ); ?>" alt="<?php echo esc_attr( $author_name ); ?>">
                                    <?php endif; ?>
                                </div>

                                <?php if ($author_fb || $author_tw || $author_ig || $author_li || $author_www) : ?>
                                    <div class="single-content__post-content__bottom-author__left__social">
                                        <?php if ($author_fb) : ?><img src="<?php echo esc_url( get_template_directory_uri() . '/static/images/facebook-icon-blue.png' ); ?>" alt="Facebook"><a href="<?php echo esc_url($author_fb); ?>" target="_blank" rel="noopener">Facebook</a><?php endif; ?>
                                        <?php if ($author_tw) : ?><img src="<?php echo esc_url( get_template_directory_uri() . '/static/images/twitter-icon-blue.png' ); ?>" alt="Twitter"><a href="<?php echo esc_url($author_tw); ?>" target="_blank" rel="noopener">Twitter</a><?php endif; ?>
                                        <?php if ($author_ig) : ?><img src="<?php echo esc_url( get_template_directory_uri() . '/static/images/instagram-icon-blue.png' ); ?>" alt="Instagram"><a href="<?php echo esc_url($author_ig); ?>" target="_blank" rel="noopener">Instagram</a><?php endif; ?>
                                        <?php if ($author_li) : ?><img src="<?php echo esc_url( get_template_directory_uri() . '/static/images/Linkedin-icon-blue.png' ); ?>" alt="Linkedin"><a href="<?php echo esc_url($author_li); ?>" target="_blank" rel="noopener">LinkedIn</a><?php endif; ?>
                                        <?php if ($author_www) : ?><img src="<?php echo esc_url( get_template_directory_uri() . '/static/images/browser-icon.png' ); ?>" alt="Website"><a href="<?php echo esc_url($author_www); ?>" target="_blank" rel="noopener">Website</a><?php endif; ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                            <div class="single-content__post-content__bottom-author__right">
                                <span class="single-content__post-content__bottom-author__right__eyebrow">About the author</span>
                                <p class="single-content__post-content__bottom-author__right__name"><?php echo esc_html($author_name); ?></p>

                                <?php if (!empty($author_headline)) : ?>
                                    <p><?php echo esc_html($author_headline); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($author_large_bio)) : ?>
                                    <p><?php echo wp_kses_post($author_large_bio); ?></p>
                                <?php endif; ?>

                            </div>

                        </section>

                        <hr>


                        <section class="single-content__post-content__share">
                            <span class="single-content__post-content__share__label">Share:</span>

                            <a class="single-content__post-content__share__link"
                               href="<?php echo esc_url("https://www.facebook.com/sharer/sharer.php?u={$u}"); ?>"
                               onclick="window.open(this.href,'sharer','width=600,height=500');return false;"
                               rel="noopener"><img src="<?php echo esc_url( get_template_directory_uri() . '/static/images/facebook-icon-blue.png' ); ?>" alt="Facebook"></a>

                            <a class="single-content__post-content__share__link"
                               href="<?php echo esc_url("https://twitter.com/intent/tweet?text={$t}&url={$u}"); ?>"
                               onclick="window.open(this.href,'sharer','width=600,height=500');return false;"
                               rel="noopener"><img src="<?php echo esc_url( get_template_directory_uri() . '/static/images/twitter-icon-blue.png' ); ?>" alt="Twitter"></a>

                            <a class="single-content__post-content__share__link"
                               href="<?php echo esc_url("https://www.linkedin.com/sharing/share-offsite/?url={$u}"); ?>"
                               onclick="window.open(this.href,'sharer','width=600,height=500');return false;"
                               rel="noopener"><img src="<?php echo esc_url( get_template_directory_uri() . '/static/images/linkedin-icon-blue.png' ); ?>" alt="Linkedin"></a>

                        </section>

                        <section class="single-content__post-content__feedback h2">
                            <span class="single-content__post-content__feedback__heading">Was this article helpful?</span>
                            <div class="single-content__post-content__feedback__rating">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/static/images/thumbs-up.png' ); ?>" alt="Yes" class="js-feedback-helpful-yes">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/static/images/thumbs-down.png' ); ?>" alt="No" class="js-feedback-helpful-no">
                            </div>
                            <div class="single-content__post-content__feedback__form">
                                placeholder
                            </div>
                            <div class="single-content__post-content__feedback__thank-you">
                                <p>Thank you for your feedback!</p>
                            </div>
                        </section>


                        <section class="single-content__post-content__citations">
                            <div class="single-content__post-content__citations__header">
                                <span class="h3">Article Sources</span>
                                <button class="js-open-citations"></button>
                            </div>
                            <div class="single-content__post-content__citations__inner">
                                <?php echo $citations ?>
                            </div>
                        </section>



                    </div>
                </div>
            </div>
        </section>


        <section class="single-related-posts">
            <?php if ($related->have_posts()) : ?>
                <div class="container">
                    <div class="single-related-posts__header">
                        <span class="h2">Related Articles</span>
                    </div>
                    <div class="single-related-posts__grid">
                        <?php while ($related->have_posts()) : $related->the_post(); ?>
                            <article class="article-card article-card--slide">
                                <a href="<?php the_permalink(); ?>" class="article-card__image">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                                <div class="article-card__content">
                                    <div class="article-card__content__date"><?php echo get_the_date(); ?></div>
                                    <a class="article-card__content__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    <div class="article-card__content__excerpt"><?php the_excerpt(); ?></div>
                                    <a href="<?php the_permalink(); ?>" class="article-card__content__link">Read More</a>
                                </div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                        <div class="empty"></div>
                    </div>
                </div>
            <?php endif; ?>
        </section>

    </main><!-- #main -->

<?php
get_footer();
