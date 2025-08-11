<section class="values">
    <div class="container">
        <div class="values__inner">


            <?php if (have_rows('values')) : ?>
                <?php while (have_rows('values')) : the_row();

                    $value_name = get_sub_field('value_name');
                    $value_definition = get_sub_field('value_definition');
                    ?>
                    <div class="values__inner__row">
                        <div class="values__inner__row__left">
                            <span class="h2"><?php echo esc_html($value_name); ?></span>
                        </div>
                        <div class="values__inner__row__right">
                            <?php echo $value_definition; // WYSIWYG already escaped ?>
                        </div>

                    </div>


                <?php endwhile; ?>
            <?php endif; ?>


        </div>
    </div>
</section>
