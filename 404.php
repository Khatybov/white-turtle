<?php
get_header ();
?>
    <section class="error-404 not-found">
        <?php get_template_part ('template-parts/post-header'); ?>
        <div class="post-content">
            <p class="error-404-icon">;(</p>
            <p class="error-404-text">
                <?php _e (
                    'It looks like nothing was found at this location. Maybe try a search?',
                    'white-turtle'
                ); ?>
            </p>
            <div class="error-404-search">
                <?php get_search_form (); ?>
            </div>
        </div>
    </section>
<?php
get_footer ();
