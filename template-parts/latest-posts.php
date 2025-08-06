<section class="latest-posts">
    <div class="container">
        <div class="latest-posts__inner">

            <div class="latest-posts__inner__header">
                <span class="h2">
                    <?php the_sub_field('section_title'); ?>
                </span>
                <?php
                $link = get_sub_field('link');
                if ($link):
                    ?>
                    <a
                        class="btn"
                        href="<?php echo esc_url($link['url']); ?>"
                        target="<?php echo esc_attr($link['target'] ?: '_self'); ?>"
                    >
                        <?php echo esc_html($link['title']); ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <div class="latest-posts__grid">
        <?php
        $latest_posts = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => 9
        ]);
        if ($latest_posts->have_posts()):
            while ($latest_posts->have_posts()): $latest_posts->the_post();
                ?>
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
                        <div class="article-card__content__date">
                            <?php echo get_the_date(); ?>
                        </div>
                        <a class="article-card__content__title" href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                        <div class="article-card__content__excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="article-card__content__link">
                            Read More →
                        </a>
                    </div>
                </article>
            <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>
