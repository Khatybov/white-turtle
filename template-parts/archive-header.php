<header class="archive-header">
    <?php
    whiteturtle_archive_post_format_icon ();

    whiteturtle_page_parents ();
    whiteturtle_page_title ();
    whiteturtle_archive_description ();

    if (is_search ()) {
        get_search_form ();
    }

    whiteturtle_page_children ();
    ?>
</header>
