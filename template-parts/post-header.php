<header class="post-header">
    <?php
    if (is_singular ()) {
        whiteturtle_page_parents ();
    }

    if (is_singular () || is_404 ()) {
        whiteturtle_page_title ();
    } else {
        whiteturtle_post_title ();
    }

    whiteturtle_post_thumbnail ();

    if (is_singular ()) {
        whiteturtle_page_children ();
    }

    whiteturtle_post_header_excerpt ();
    ?>
</header>

