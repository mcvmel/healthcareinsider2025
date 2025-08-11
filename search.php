<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package healthcareinsider2025
 */

get_header();
?>

    <main id="primary" class="site-main">


        <section class="single-hero">
            <div class="container">
                <div class="single-hero__inner">
                    <h1 class="h2">
                        <?php
                        /* translators: %s: search query. */
                        printf(esc_html__('Search Results: %s', 'healthcareinsider2025'), '<span>' . get_search_query() . '</span>');
                        ?>
                    </h1>
                    <?php get_search_form(); ?>
                </div>
            </div>
        </section>


        <section class="search-results">
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


    </main><!-- #main -->

<?php
get_footer();
