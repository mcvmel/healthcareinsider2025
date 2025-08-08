<?php
/**
 * Template Name: Page Builder
 */
$category = get_queried_object();
$paged = max(1, get_query_var('paged'), get_query_var('page'));

$q = new WP_Query([
    'category_name' => 'insurer-reviews',
    'posts_per_page' => 8,
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => $paged,
]);
get_header();
?>

    <main id="primary" class="site-main">

        <section class="image-with-text image-with-text--right ice-swoop">
            <div class="container">
                <div class="image-with-text__inner">

                    <div class="image-with-text__inner__image">
                        <img src="/wp-content/uploads/2025/08/compare-plans-compressed.png" alt="Insurer Reviews">
                    </div>

                    <div class="image-with-text__inner__content">
                        <h1><?php echo esc_html($category->name); ?></h1>
                        <p><?php echo category_description($category->term_id); ?></p>

                    </div>

                </div>
            </div>
        </section>

        <div class="filter-reviews-container">
            <div class="container">

                <div class="filter-reviews">
                    <div class="filter-reviews__filter">
                        <a href="#" class="btn js-filter-by-state">Filter Options by State</a>
                        <ul class="filter-reviews__filter__ul" data-simplebar data-simplebar-auto-hide="false">
                            <?php if ($q->have_posts()) : ?>
                                <?php while ($q->have_posts()) : $q->the_post();
                                    $post_id = get_the_ID();
                                    ?>

                                    <li class=""
                                        data-id="<?php echo esc_attr($post_id); ?>>"><?php echo esc_html(get_the_title()); ?></li>
                                <?php endwhile; ?>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        </ul>


                    </div>
                    <div class="filter-reviews__insurer-reviews">
                        <?php if ($q->have_posts()) : ?>
                            <?php while ($q->have_posts()) : $q->the_post();

                                $post_id = get_the_ID();

                                $coverage_states = get_field('coverage_states', $post_id);

                                $rating_field_keys = [
                                    'coverage_breadth_accessibility_rating',
                                    'plan_variety_customization_rating',
                                    'affordability_value_rating',
                                    'innovation_care_quality_rating',
                                    'consumer_experience_transparency_rating',
                                ];

                                $rating_values = [];

                                if (function_exists('get_fields')) {
                                    $all_fields = get_fields($post_id) ?: [];

                                    $find_rating_values = function ($fields_array) use (&$find_rating_values, $rating_field_keys, &$rating_values) {
                                        foreach ($fields_array as $field_key => $field_value) {
                                            if (is_array($field_value)) {
                                                $find_rating_values($field_value);
                                                continue;
                                            }
                                            if (in_array($field_key, $rating_field_keys, true) && is_numeric($field_value)) {
                                                $rating_values[] = (float)$field_value;
                                            }
                                        }
                                    };

                                    $find_rating_values($all_fields);
                                }

                                if (count($rating_values) < count($rating_field_keys)) {
                                    foreach ($rating_field_keys as $key) {
                                        $meta_value = get_post_meta($post_id, $key, true);
                                        if (is_numeric($meta_value)) {
                                            $rating_values[] = (float)$meta_value;
                                        }
                                    }
                                }

                                $rating_values = array_slice($rating_values, 0, 5);
                                $average_rating = count($rating_values) ? number_format(array_sum($rating_values) / count($rating_values), 1) : '';

                                $text_field_keys = ['coverage_areas', 'plan_types', 'top_highlight'];
                                $text_field_values = array_fill_keys($text_field_keys, '');

                                if (!empty($all_fields)) {
                                    $find_text_values = function ($fields_array) use (&$find_text_values, $text_field_keys, &$text_field_values) {
                                        foreach ($fields_array as $field_key => $field_value) {
                                            if (is_array($field_value)) {
                                                $find_text_values($field_value);
                                                continue;
                                            }
                                            if (in_array($field_key, $text_field_keys, true) && $field_value !== '' && $text_field_values[$field_key] === '') {
                                                $text_field_values[$field_key] = $field_value;
                                            }
                                        }
                                    };
                                    $find_text_values($all_fields);
                                }

                                foreach ($text_field_keys as $key) {
                                    if ($text_field_values[$key] === '') {
                                        $meta_value = get_post_meta($post_id, $key, true);
                                        if ($meta_value !== '') {
                                            $text_field_values[$key] = $meta_value;
                                        }
                                    }
                                }


                                $coverage_state_values = [];
                                if (!empty($coverage_states) && is_array($coverage_states)) {
                                    foreach ($coverage_states as $state) {
                                        if (!empty($state['value'])) {
                                            $coverage_state_values[] = strtolower($state['value']); // lowercase just in case
                                        }
                                    }
                                }


                                $coverage_areas_content = $text_field_values['coverage_areas'];
                                $plan_types_content = $text_field_values['plan_types'];
                                $top_highlight_content = $text_field_values['top_highlight'];
                                $coverage_states_attr = esc_attr(implode(', ', $coverage_state_values));
                                ?>

                                <div class="filter-reviews__insurer-reviews__item white-card"
                                     data-id="<?php echo esc_attr($post_id); ?>>"
                                     data-states="<?php echo $coverage_states_attr; ?>">
                                    <div class="filter-reviews__insurer-reviews__item__left">
                                        <div class="filter-reviews__insurer-reviews__item__left__image">
                                            <?php
                                            if (has_post_thumbnail()) {
                                                the_post_thumbnail('medium', array('alt' => esc_attr(get_the_title())));
                                            }
                                            ?>
                                        </div>
                                        <div class="filter-reviews__insurer-reviews__item__left__rating">
                                            <p>HealthCareInsider Rating</p>
                                            <p>
                                                <strong><?php echo $average_rating !== '' ? esc_html($average_rating) : ''; ?>
                                                    /10</strong>
                                            </p>
                                        </div>
                                        <a class="btn" href="<?php echo esc_url(get_permalink()); ?>">Read Full Review</a>
                                    </div>
                                    <div class="filter-reviews__insurer-reviews__item__right">
                                        <div class="filter-reviews__insurer-reviews__item__right__title h2">
                                            <?php echo esc_html(get_the_title()); ?>
                                        </div>
                                        <div class="filter-reviews__insurer-reviews__item__right__excerpt">
                                            <?php
                                            $raw_excerpt = get_post_field('post_excerpt', get_the_ID(), 'raw');
                                            if ($raw_excerpt) {
                                                echo wpautop(wp_kses_post($raw_excerpt));
                                            }
                                            ?>
                                            <span class="small-heading">Coverage Areas</span>
                                            <?php echo $coverage_areas_content ? wp_kses_post($coverage_areas_content) : ''; ?>
                                            <span class="small-heading">Plan Types</span>
                                            <?php echo $plan_types_content ? wp_kses_post($plan_types_content) : ''; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>

                            <nav class="pagination">
                                <?php echo paginate_links(array(
                                    'total' => $q->max_num_pages,
                                    'prev_text' => '',
                                    'next_text' => '',
                                )); ?>
                            </nav>

                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="state-filter-flyout">
            <div class="state-filter-flyout__header">
                <span class="small-heading">Select A State</span>
                <button class="js-close-filter-by-state"></button>
            </div>
            <div class="state-filter-flyout__states">
                <ul class="state-filter-flyout__states__list">
                    <li class="state-filter-flyout__states__list__item" data-state="al">Alabama</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ak">Alaska</li>
                    <li class="state-filter-flyout__states__list__item" data-state="az">Arizona</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ar">Arkansas</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ca">California</li>
                    <li class="state-filter-flyout__states__list__item" data-state="co">Colorado</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ct">Connecticut</li>
                    <li class="state-filter-flyout__states__list__item" data-state="de">Delaware</li>
                    <li class="state-filter-flyout__states__list__item" data-state="fl">Florida</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ga">Georgia</li>
                    <li class="state-filter-flyout__states__list__item" data-state="hi">Hawaii</li>
                    <li class="state-filter-flyout__states__list__item" data-state="id">Idaho</li>
                    <li class="state-filter-flyout__states__list__item" data-state="il">Illinois</li>
                    <li class="state-filter-flyout__states__list__item" data-state="in">Indiana</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ia">Iowa</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ks">Kansas</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ky">Kentucky</li>
                    <li class="state-filter-flyout__states__list__item" data-state="la">Louisiana</li>
                    <li class="state-filter-flyout__states__list__item" data-state="me">Maine</li>
                    <li class="state-filter-flyout__states__list__item" data-state="md">Maryland</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ma">Massachusetts</li>
                    <li class="state-filter-flyout__states__list__item" data-state="mi">Michigan</li>
                    <li class="state-filter-flyout__states__list__item" data-state="mn">Minnesota</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ms">Mississippi</li>
                    <li class="state-filter-flyout__states__list__item" data-state="mo">Missouri</li>
                    <li class="state-filter-flyout__states__list__item" data-state="mt">Montana</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ne">Nebraska</li>
                    <li class="state-filter-flyout__states__list__item" data-state="nv">Nevada</li>
                    <li class="state-filter-flyout__states__list__item" data-state="nh">New Hampshire</li>
                    <li class="state-filter-flyout__states__list__item" data-state="nj">New Jersey</li>
                    <li class="state-filter-flyout__states__list__item" data-state="nm">New Mexico</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ny">New York</li>
                    <li class="state-filter-flyout__states__list__item" data-state="nc">North Carolina</li>
                    <li class="state-filter-flyout__states__list__item" data-state="nd">North Dakota</li>
                    <li class="state-filter-flyout__states__list__item" data-state="oh">Ohio</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ok">Oklahoma</li>
                    <li class="state-filter-flyout__states__list__item" data-state="or">Oregon</li>
                    <li class="state-filter-flyout__states__list__item" data-state="pa">Pennsylvania</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ri">Rhode Island</li>
                    <li class="state-filter-flyout__states__list__item" data-state="sc">South Carolina</li>
                    <li class="state-filter-flyout__states__list__item" data-state="sd">South Dakota</li>
                    <li class="state-filter-flyout__states__list__item" data-state="tn">Tennessee</li>
                    <li class="state-filter-flyout__states__list__item" data-state="tx">Texas</li>
                    <li class="state-filter-flyout__states__list__item" data-state="ut">Utah</li>
                    <li class="state-filter-flyout__states__list__item" data-state="vt">Vermont</li>
                    <li class="state-filter-flyout__states__list__item" data-state="va">Virginia</li>
                    <li class="state-filter-flyout__states__list__item" data-state="wa">Washington</li>
                    <li class="state-filter-flyout__states__list__item" data-state="wv">West Virginia</li>
                    <li class="state-filter-flyout__states__list__item" data-state="wi">Wisconsin</li>
                    <li class="state-filter-flyout__states__list__item" data-state="wy">Wyoming</li>
                </ul>

            </div>

        </div>
    </main><!-- #main -->

<?php
get_footer();
