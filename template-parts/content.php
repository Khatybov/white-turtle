<article id="post-<?php the_ID (); ?>" <?php post_class ('post-wrapper'); ?>>

    <?php get_template_part ('template-parts/post-header'); ?>


    <div class="post-content__wrapper">
        <div class="post-content">
            <?php whiteturtle_post_content () ?>
        </div>
        <div class="clear"></div>
        <?php whiteturtle_post_content_hidden_controls () ?>
    </div>

    <?php get_template_part ('template-parts/post-meta'); ?>

    <?php
    if (is_singular () && !is_front_page ()) {
        comments_template ();
    }
    ?>
</article>