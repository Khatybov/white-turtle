<?php
get_header ();

if (is_author ()) {
    get_template_part ('template-parts/author-header');
} elseif (!is_home () && !is_singular ()) {
    get_template_part ('template-parts/archive-header');
}

if (have_posts ()) {
    while (have_posts ()) {
        the_post ();
    get_template_part ('template-parts/content');
    }
    get_template_part ('template-parts/archive-footer');
} else {
    get_template_part ('template-parts/content-none');
}

get_footer ();