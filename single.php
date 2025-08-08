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
$author_id = get_the_author_meta('ID');
$reviewed_by = get_field('reviewed_by');
$coverage_areas = get_field('coverage_areas');
$plan_types = get_field('plan_types');
$top_highlight = get_field('top_highlight');
$post_disclaimer = get_field('post_disclaimer', 'option');

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

get_header();
?>

    <main id="primary" class="site-main">

        <section class="single-hero">
            <div class="container">
                <div class="single-hero__inner">
                    <div class="single-hero__inner__bread-crumbs">
                        <?php
                        $categories = get_the_category();
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
                        <ul class="single-content__filter__ul" data-simplebar data-simplebar-auto-hide="false">
                            <li class="" data-id=""><?php echo esc_html(get_the_title()); ?></li>
                        </ul>


                    </div>

                    <div class="single-content__post-content">

                        <section class="single-content__post-content__credits">
                            <div class="single-content__post-content__credits__column">
                                <?php
                                $author_image = get_field('user_photo', 'user_' . $author_id);
                                $author_name = get_the_author_meta('display_name', $author_id);
                                $author_headline = get_field('user_headline', 'user_' . $author_id);
                                ?>
                                <div class="single-content__post-content__credits__column__user">
                                    <?php if (!empty($author_image) && is_array($author_image)) : ?>
                                        <img class="single-content__post-content__credits__column__user__photo"
                                             src="<?php echo esc_url($author_image['url']); ?>"
                                             alt="<?php echo esc_attr($author_image['alt'] ?: $author_name); ?>">
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

                        <div class="single-content__post-content__intro white-card white-card--no-hover">
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

                            <div clas="">
                                <?php echo $top_highlight; ?>
                            </div>

                        </div>

                        ???


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
                                              data-number="<?php echo esc_attr($coverage_rating); ?>"><?php echo esc_html($coverage_rating); ?>/10</span>
                                    <?php endif; ?>
                                    <?php if ($coverage_note): ?>
                                        <p class="single-content__post-content__hci-rating__list__item__note"><?php echo wp_kses_post($coverage_note); ?></p>
                                    <?php endif; ?>
                                </div>


                                <div class="single-content__post-content__hci-rating__list__item">
                                    <span class="single-content__post-content__hci-rating__list__item__label">Plan Variety & Customization</span>
                                    <?php if ($variety_rating !== null): ?>
                                        <span class="single-content__post-content__hci-rating__list__item__value"
                                              data-number="<?php echo esc_attr($variety_rating); ?>">
                <?php echo esc_html($variety_rating); ?>/10
            </span>
                                    <?php endif; ?>

                                    <?php if ($variety_note): ?>
                                        <p class="single-content__post-content__hci-rating__list__item__note"><?php echo wp_kses_post($variety_note); ?></p>
                                    <?php endif; ?>

                                </div>


                                <div class="single-content__post-content__hci-rating__list__item">
                                    <span class="single-content__post-content__hci-rating__list__item__label">Affordability & Value</span>
                                    <?php if ($afford_rating !== null): ?>
                                        <span class="single-content__post-content__hci-rating__list__item__value"
                                              data-number="<?php echo esc_attr($afford_rating); ?>">
                <?php echo esc_html($afford_rating); ?>/10
            </span>
                                    <?php endif; ?>

                                    <?php if ($afford_note): ?>
                                        <p class="single-content__post-content__hci-rating__list__item__note"><?php echo wp_kses_post($afford_note); ?></p>
                                    <?php endif; ?>

                                </div>


                                <div class="single-content__post-content__hci-rating__list__item">
                                    <span class="single-content__post-content__hci-rating__list__item__label">Innovation & Care Quality</span>
                                    <?php if ($innovation_rating !== null): ?>
                                        <span class="single-content__post-content__hci-rating__list__item__value"
                                              data-number="<?php echo esc_attr($innovation_rating); ?>">
                <?php echo esc_html($innovation_rating); ?>/10
            </span>
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
                                              data-number="<?php echo esc_attr($consumer_rating); ?>">
                <?php echo esc_html($consumer_rating); ?>/10
            </span>
                                    <?php endif; ?>

                                    <?php if ($consumer_note): ?>
                                        <p class="single-content__post-content__hci-rating__list__item__note"><?php echo wp_kses_post($consumer_note); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>


                        </section>


                        ???

                        <?php
                        while (have_posts()) :
                            the_post();

                            get_template_part('template-parts/content', get_post_type());

                            the_post_navigation(
                                array(
                                    'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'healthcareinsider2025') . '</span> <span class="nav-title">%title</span>',
                                    'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'healthcareinsider2025') . '</span> <span class="nav-title">%title</span>',
                                )
                            );

                            // If comments are open or we have at least one comment, load up the comment template.
                            if (comments_open() || get_comments_number()) :
                                comments_template();
                            endif;

                        endwhile; // End of the loop.
                        ?>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- #main -->

<?php
get_footer();
