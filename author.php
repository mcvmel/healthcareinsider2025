<?php
/**
 * Basic Author Archive Template
 * @package yourtheme
 */

get_header();

// Author (queried user)
$author_id   = (int) get_queried_object_id();
$author_name = get_the_author_meta('display_name', $author_id);

// ACF user fields
$author_headline   = get_field('user_headline',     'user_' . $author_id);
$author_large_bio  = get_field('user_large_bio',    'user_' . $author_id);
$author_fb         = get_field('user_facebook_url', 'user_' . $author_id);
$author_tw         = get_field('user_twitter_url',  'user_' . $author_id);
$author_ig         = get_field('user_instagram_url','user_' . $author_id);
$author_li         = get_field('user_linkedin_url', 'user_' . $author_id);
$author_www        = get_field('user_website_url',  'user_' . $author_id);

// Image (force raw to handle ID/array/URL consistently)
$author_image_raw = get_field('user_photo', 'user_' . $author_id, false);
$author_image_url = '';
$author_image_alt = $author_name;

// Normalize image to URL + ALT (same as single template)
if (is_numeric($author_image_raw)) {
    $author_image_url = wp_get_attachment_image_url((int)$author_image_raw, 'full');
    $author_image_alt = get_post_meta((int)$author_image_raw, '_wp_attachment_image_alt', true) ?: $author_name;
} elseif (is_array($author_image_raw) && !empty($author_image_raw['url'])) {
    $author_image_url = $author_image_raw['url'];
    $author_image_alt = !empty($author_image_raw['alt']) ? $author_image_raw['alt'] : $author_name;
} elseif (is_string($author_image_raw)) {
    $author_image_url = $author_image_raw;
}

// Final fallback (theme default, then Gravatar) — matches single
if (!$author_image_url) {
    $theme_fallback   = get_template_directory_uri() . '/static/images/default-author.png';
    $grav_url         = get_avatar_url($author_id, ['size' => 256]);
    $author_image_url = $grav_url ?: $theme_fallback;
}
?>

<main id="primary" class="site-main">
    <section class="ice-swoop">
        <div class="container">

            <section class="author-hero">
                <div class="author-hero__left">
                    <div class="author-hero__left__photo">
                        <img src="<?php echo esc_url($author_image_url); ?>" alt="<?php echo esc_attr($author_image_alt ?: $author_name); ?>">
                    </div>

                    <?php if ($author_fb || $author_tw || $author_ig || $author_li || $author_www) : ?>
                        <div class="author-hero__left__social">
                            <?php if ($author_fb) : ?>
                                <div><img src="<?php echo esc_url(get_template_directory_uri() . '/static/images/facebook-icon-blue.png'); ?>" alt="Facebook">
                                    <a href="<?php echo esc_url($author_fb); ?>" target="_blank" rel="noopener">Facebook</a></div>
                            <?php endif; ?>
                            <?php if ($author_tw) : ?>
                                <div><img src="<?php echo esc_url(get_template_directory_uri() . '/static/images/twitter-icon-blue.png'); ?>" alt="Twitter">
                                    <a href="<?php echo esc_url($author_tw); ?>" target="_blank" rel="noopener">Twitter</a></div>
                            <?php endif; ?>
                            <?php if ($author_ig) : ?>
                                <div><img src="<?php echo esc_url(get_template_directory_uri() . '/static/images/instagram-icon-blue.png'); ?>" alt="Instagram">
                                    <a href="<?php echo esc_url($author_ig); ?>" target="_blank" rel="noopener">Instagram</a></div>
                            <?php endif; ?>
                            <?php if ($author_li) : ?>
                                <div><img src="<?php echo esc_url(get_template_directory_uri() . '/static/images/Linkedin-icon-blue.png'); ?>" alt="LinkedIn">
                                    <a href="<?php echo esc_url($author_li); ?>" target="_blank" rel="noopener">LinkedIn</a></div>
                            <?php endif; ?>
                            <?php if ($author_www) : ?>
                                <div><img src="<?php echo esc_url(get_template_directory_uri() . '/static/images/browser-icon.png'); ?>" alt="Website">
                                    <a href="<?php echo esc_url($author_www); ?>" target="_blank" rel="noopener">Website</a></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="author-hero__right">
                    <span class="author-hero__right__eyebrow">About the author</span>
                    <p class="author-hero__right__name">
                        <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                            <?php echo esc_html($author_name); ?>
                        </a>
                    </p>

                    <?php if (!empty($author_headline)) : ?>
                        <p><?php echo esc_html($author_headline); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($author_large_bio)) : ?>
                        <p><?php echo wp_kses_post($author_large_bio); ?></p>
                    <?php endif; ?>
                </div>
            </section>

        </div>
    </section>


    <section class="search-results search-results--author">
        <div class="search-results__header">
            <p class="small-heading">Latest Articles by <?php echo esc_html($author_name); ?></p>
        </div>
        <div class="container">
            <div class="search-results__grid">
                <?php if (have_posts()) :
                    /* Start the Loop */
                    while (have_posts()) :
                        the_post(); ?>
                        <article class="article-card">
                            <a href="<?php the_permalink(); ?>" class="article-card__image">
                                <?php the_post_thumbnail('medium'); ?>
                                <?php
                                $category = get_the_category();
                                if ($category):
                                    ?>
                                    <span class="article-card__image__category">
                                <?php echo esc_html($category[0]->name); ?>
                            </span>
                                <?php endif; ?>
                            </a>
                            <div class="article-card__content">
                                <div class="article-card__content__date"><?php echo get_the_date(); ?></div>
                                <a class="article-card__content__title"
                                   href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                <div class="article-card__content__excerpt"><?php the_excerpt(); ?></div>
                                <a href="<?php the_permalink(); ?>" class="article-card__content__link">Read
                                    More</a>
                            </div>
                        </article>
                    <?php endwhile;
                else :?>
                    <p>No results found.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
