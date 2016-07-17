<?php

require_once 'comments-walker.php';


function whiteturtle_setup () {
    
    load_theme_textdomain( 'white-turtle', get_template_directory_uri().'/languages' );
    
    register_nav_menus (
        array (
            'primary' => __ ('Top primary menu', 'white-turtle'),
        )
    );
    
    add_theme_support (
        'html5',
        array (
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        )
    );
    
    add_theme_support (
        'post-formats',
        array (
            'aside',
            'chat',
            'gallery',
            'link',
            'image',
            'quote',
            'status',
            'video',
            'audio'
        )
    );
    
    add_theme_support ('title-tag');
    
    add_theme_support ('post-thumbnails');
    
    add_theme_support ('automatic-feed-links');
    
    add_theme_support (
        'custom-logo',
        array (
            'height' => 100,
            'width' => 100,
            'flex-height' => true,
        )
    );
    
    set_post_thumbnail_size (500, 9999);
}

add_action ('after_setup_theme', 'whiteturtle_setup');

function whiteturtle_widgets_init () {
    register_sidebar (
        array (
            'name' => __ ('Widget Area','white-turtle'),
            'id' => 'sidebar',
            'description' => '',
            'before_widget' => '<div id="%1$s" class="sidebar__widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}

add_action ('widgets_init', 'whiteturtle_widgets_init');

function whiteturtle_styles () {
    wp_enqueue_style (
        'whiteturtle-google-fonts',
        'https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700|PT+Sans:400,700&subset=latin,cyrillic'
    );
    wp_enqueue_style (
        'whiteturtle-normilize',
        'https://cdnjs.cloudflare.com/ajax/libs/normalize/4.1.1/normalize.min.css'
    );
    
    // Add Genericons, used in the main stylesheet.
    wp_enqueue_style (
        'whiteturtle-genericons',
        get_template_directory_uri () . '/dist/vendor/genericons/genericons.css'
    );
    
    //Magnific-Popup css
    wp_enqueue_style (
        'whiteturtle-Magnific-Popup-css',
        get_template_directory_uri () . '/dist/vendor/Magnific-Popup/magnific-popup.css'
    );
    
    wp_enqueue_style ('whiteturtle-style', get_template_directory_uri () . '/dist/css/style.css');
}

add_action ('wp_enqueue_scripts', 'whiteturtle_styles');

function whiteturtle_scripts () {
    
    //Magnific-Popup script
    wp_enqueue_script (
        'whiteturtle-Magnific-Popup-js',
        get_template_directory_uri () . '/dist/vendor/Magnific-Popup/jquery.magnific-popup.min.js',
        array ( 'jquery' ),
        '',
        true
    );
    
    wp_enqueue_script (
        'whiteturtle-script',
        get_template_directory_uri () . '/dist/js/functions.js',
        array ( 'jquery' ),
        '',
        true
    );
    
    wp_localize_script (
        'whiteturtle-script',
        'whiteturtle_vars',
        array (
            'ajaxUrl' => admin_url ('admin-ajax.php'),
            'translate' => array (
                'open-in-new-window' => __ ('Open in new window', 'white-turtle'),
                'more' => __ ('More', 'white-turtle')
            ),
        )
    );
}

add_action ('wp_enqueue_scripts', 'whiteturtle_scripts');

if (!isset($content_width)) {
    $content_width = 700;
}

//filters

function whiteturtle_filter_the_password_form () {
    global $post;
    
    $post = get_post ($post);
    $id = 'pwbox-' . (empty($post->ID) ? rand () : $post->ID);
    
    
    $action = esc_url (site_url ('wp-login.php?action=postpass', 'login_post'));
    $title = __ ('This content is password protected. To view it please enter your password below:', 'white-turtle');
    $button = __ ('Enter the password', 'white-turtle');
    
    $output = '';
    
    $output .= "<form action='$action' class='post-password-form' method='post'>";
    
    $output .= "<label for='$id'>$title</label>";
    
    $output .= "<input type='password' name='post_password' id='$id' size='20'>";
    
    $output .= "<p><button type='submit' name='Submit' class='form-submit__button'>$button</button></p>";
    
    $output .= "</form>";
    
    return $output;
}

add_filter ('the_password_form', 'whiteturtle_filter_the_password_form');

function whiteturtle_filter_the_content_more_link () {
    global $post;
    $link = get_permalink () . '#more-' . $post->ID;
    $text = __ ('Read More...', 'white-turtle');
    
    return "<div class='post-see-more'><a href='$link'>$text</a></div>";
}

add_filter ('the_content_more_link', 'whiteturtle_filter_the_content_more_link');

function whiteturtle_filter_post_title_format () {
    return '%s';
}

add_filter ('protected_title_format', 'whiteturtle_filter_post_title_format');
add_filter ('private_title_format', 'whiteturtle_filter_post_title_format');

function whiteturtle_filter_wp_get_attachment_link ($link) {
    $post = get_post ();
    
    if (empty($post->post_type) || $post->post_type != 'attachment' || wp_attachment_is (
            'video',
            $post
        ) || wp_attachment_is ('audio', $post) || wp_attachment_is ('image', $post)
    ) {
        return $link;
    };
    
    $link = str_replace ("'>", "' class='attachment-link'>", $link);
    
    return str_replace (
        "<a",
        "<span class=\"genericon genericon-download genericon-download-icon \"></span> <a",
        $link
    );
    
}

add_filter ('wp_get_attachment_link', 'whiteturtle_filter_wp_get_attachment_link');

function whiteturtle_filter_prepend_attachment ($output) {
    $post = get_post ();
    
    if (wp_attachment_is ('image', $post)) {
        $metadata = wp_get_attachment_metadata ();
        
        if ($metadata) {
            
            $width = $metadata[ 'width' ];
            $height = $metadata[ 'height' ];
            
            $output = str_replace (
                '</p>',
                "<span class=\"attachment-image-resolution\">$width &times; $height</span>",
                $output
            );
        }
        
        return str_replace ('class="attachment"', 'class="attachment single-attachment-image"', $output);
    }
    
    return $output;
}

add_filter ('prepend_attachment', 'whiteturtle_filter_prepend_attachment');

//template

function whiteturtle_get_icon ($format) {
    $icons = array (
        'aside' => '<span class="genericon genericon-standard"></span>',
        'chat' => '<span class="genericon genericon-chat"></span>',
        'gallery' => '<span class="genericon genericon-gallery"></span>',
        'link' => '<span class="genericon genericon-link"></span>',
        'image' => '<span class="genericon genericon-image"></span>',
        'quote' => '<span class="genericon genericon-quote"></span>',
        'status' => '<span class="genericon genericon-status"></span>',
        'video' => '<span class="genericon genericon-video"></span>',
        'audio' => '<span class="genericon genericon-audio"></span>',
        'edit' => '<span class="genericon genericon-edit"></span>',
        'password' => '<span class="genericon genericon-key"></span>',
        'private' => '<span class="genericon genericon-hide"></span>',
        'more' => '<span class="genericon genericon-ellipsis"></span>',
        'info' => '<span class="genericon genericon-info"></span>',
        'reply' => '<span class="genericon genericon-reply-single"></span>',
        'comment' => '<span class="genericon genericon-comment"></span>',
        'sticky' => '<span class="genericon genericon-pinned"></span>',
        'search' => '<span class="genericon genericon-search"></span>',
    );
    
    if (isset($icons[ $format ])) {
        return $icons[ $format ];
    }
    
    return '';
}


function whiteturtle_archive_description () {
    $description = '';
    
    if (is_archive () && !is_author ()) {
        $description = get_the_archive_description ();
    } elseif (is_author ()) {
        $description = get_the_author_meta ('description');
        
        if ($description) {
            $description = wpautop ($description);
        }
    }
    
    if (!$description) {
        return;
    }
    
    echo "<div class='archive-description'>$description</div>";
}

function whiteturtle_archive_pagination () {
    if ($GLOBALS[ 'wp_query' ]->max_num_pages <= 1) {
        return;
    }
    ?>
    <div class="archive-pagination">
        <?php
        the_posts_pagination (
            array (
                'mid_size' => 1,
                'end_siz e' => 2,
                'prev_text' => '<span class="genericon genericon-leftarrow"></span>',
                'next_text' => '<span class="genericon genericon-rightarrow"></span>',
            )
        );
        ?>
    </div>
    <?php
}

function whiteturtle_archive_post_format_icon () {
    $query_object = get_queried_object ();
    
    if (!$query_object instanceof WP_Term || $query_object->taxonomy !== 'post_format') {
        return;
    }
    
    $post_format = strtolower ($query_object->name);
    
    $icon = whiteturtle_get_icon ($post_format);
    
    if (!$icon) {
        return;
    }
    
    echo "<div class='archive-post-format-icon'>$icon</div>";
}


function whiteturtle_get_term_parents ($term = null, $output = array ()) {
    
    if (!$term) {
        $query_object = get_queried_object ();
        
        if (!$query_object instanceof WP_Term) {
            return null;
        }
        
        $term = $query_object;
        $taxonomy = get_taxonomy ($term->taxonomy);
        
        if (!$term->parent || !$taxonomy || !$taxonomy->hierarchical) {
            return null;
        }
    }
    
    if ($term->parent) {
        if (!$output) {
            $output[] = $term;
        }
        
        $parent = get_term ($term->parent, $term->taxonomy);
        $output[] = $parent;
        
        $self_name = __FUNCTION__;
        
        return $self_name($parent, $output);
    }
    
    if (!$output) {
        return false;
    }
    
    return array_map (
        function ($term) {
            return (object)array (
                'name' => $term->name,
                'link' => get_term_link ($term->term_id, $term->taxonomy)
            );
        },
        array_reverse ($output)
    );
}

function whiteturtle_get_post_parents () {
    
    global $post;
    
    if (!$post) {
        return false;
    }
    
    $parents = get_post_ancestors ($post->ID);
    
    if (!$parents) {
        return false;
    }
    
    $parents = array_reverse ($parents);
    
    $parents[] = $post->ID;
    
    return array_map (
        function ($post_id) {
            $post = get_post ($post_id);
            
            return (object)array (
                'name' => $post->post_title,
                'link' => get_the_permalink ($post->ID)
            );
        },
        $parents
    );
}

function whiteturtle_page_parents () {
    $links = array ();
    
    if (is_singular ()) {
        $links = whiteturtle_get_post_parents ();
    } elseif (is_archive ()) {
        $links = whiteturtle_get_term_parents ();
    }
    
    if (!$links) {
        return;
    }
    
    $index = 0;
    $length = sizeof ($links);
    
    echo "<div class='page-parents'>";
    
    foreach ($links as $item) {
        
        $name = $item->name;
        $link = $item->link;
        
        if ($index !== $length - 1) {
            echo "<a href='$link' title='$name'>$name</a> <span>/</span> ";
        } else {
            echo "<span>$name</span>";
        }
        $index++;
    }
    
    echo '</div>';
}


function whiteturtle_get_term_children () {
    
    $query_object = get_queried_object ();
    
    if (!$query_object instanceof WP_Term) {
        return false;
    }
    
    $term = $query_object;
    
    if (!$term->taxonomy) {
        return false;
    }
    
    $taxonomy = $term->taxonomy;
    
    $children = get_terms (
        array (
            'taxonomy' => $taxonomy,
            'parent' => $term->term_id
        )
    );
    
    if (!$children || is_wp_error ($children)) {
        return false;
    }
    
    return array_map (
        function ($term) use ($taxonomy) {
            return (object)array (
                'name' => $term->name,
                'link' => get_term_link ($term->term_id, $taxonomy)
            );
        },
        $children
    );
}

function whiteturtle_get_post_children () {
    global $post;
    
    $children = get_posts (
        array (
            'numberposts' => -1,
            'post_parent' => $post->ID,
            'post_type' => $post->post_type
        )
    );
    
    if (!$children || is_wp_error ($children)) {
        return false;
    }
    
    return array_map (
        function ($post) {
            return (object)array (
                'name' => $post->post_title,
                'link' => get_the_permalink ($post->ID)
            );
        },
        $children
    );
}

function whiteturtle_page_children () {
    $links = array ();
    
    $class_name = '';
    
    if (is_singular ()) {
        $links = whiteturtle_get_post_children ();
        $class_name = 'single';
    } elseif (is_archive ()) {
        $links = whiteturtle_get_term_children ();
        $class_name = 'archive';
    }
    
    if (!$links) {
        return;
    }
    
    echo "<div class='page-children page-children-$class_name'>";
    
    foreach ($links as $item) {
        
        $name = $item->name;
        $link = $item->link;
        
        echo "<div><a href='$link' title='$name'>$name</a></div>";
    }
    
    echo '</div>';
}


function whiteturtle_page_title () {
    
    if (is_archive ()) {
        $title = get_the_archive_title ();
    } elseif (is_search ()) {
        $wp_query = $GLOBALS[ 'wp_query' ];
        $search_found_results = $wp_query->found_posts;
        
        $title =
            sprintf (__ ('Search Results for: %s', 'white-turtle'), get_search_query ())
            . '<span class="search-found-results">'
            . sprintf (__ ('%s results found', 'white-turtle'), $search_found_results)
            . '</span>';
    } elseif (is_404 ()) {
        $title = __ ('Oops! That page can&rsquo;t be found.', 'white-turtle');
    } else {
        $title = get_the_title ();
    }
    
    if (!$title) {
        return;
    }
    
    $class_name = '';
    
    if (is_singular () || is_404 ()) {
        $class_name = 'page-title-single';
    }
    
    echo "<h1 class='page-title $class_name'>$title</h1>";
}

function whiteturtle_post_title () {
    $title = get_the_title ();
    $url = esc_url (get_permalink ());
    
    if (!$title) {
        return;
    }
    
    //Do not show title for specified post format in archive
    $exclude_post_format = array (
        'quote',
        'status',
    );
    
    if (in_array (get_post_format (), $exclude_post_format) && (is_archive () || is_home() || is_search())) {
        return;
    }
    
    echo "<h2 class='post-title'><a href='$url' title='$title'>$title</a></h2>";
}


function whiteturtle_post_thumbnail () {
    if (post_password_required () || is_attachment () || !has_post_thumbnail ()) {
        return;
    }
    
    //Do not show thumbnail for specified post format in archive
    $exclude_post_format = array (
        'link',
        'image',
        'quote',
        'status',
        'video',
        'audio',
    );
    
    if (in_array (get_post_format (), $exclude_post_format) && !is_singular ()) {
        return;
    }
    
    $thumbnail = get_the_post_thumbnail (null, 'post-thumbnail', array ( 'alt' => the_title_attribute ('echo=0') ));
    $link = esc_url (get_permalink ());
    
    echo "<div class='post-thumbnail'>";
    
    if (is_singular ()) {
        echo $thumbnail;
    } else {
        echo "<a class='post-thumbnail__link' href='$link' aria-hidden='true'>$thumbnail</a>";
    }
    
    echo "</div>";
}


function whiteturtle_post_header_excerpt () {
    if (!has_excerpt () || is_home () || is_archive ()) {
        return;
    }
    
    echo '<div class="post-excerpt">';
    the_excerpt ();
    echo '</div>';
}

function whiteturtle_post_content () {
    $excerpt = '';
    
    if ((is_home () || is_archive ()) && has_excerpt ()) {
        $excerpt = get_the_excerpt () . whiteturtle_filter_the_content_more_link ();
    }
    
    ob_start ();
    the_content ();
    $content = ob_get_clean ();
    
    if ($excerpt) {
        echo $excerpt;
    } elseif ($content) {
        echo $content;
    } else {
        echo '<p>' . __ ('The post has no content', 'white-turtle') . '</p>';
    }
    
}

function whiteturtle_no_results_content () {
    if (is_home () && current_user_can ('publish_posts')) {
        $link = esc_url (admin_url ('post-new.php'));
        $text = __ ('Ready to publish your first post?', 'white-turtle');
        echo "<a href='$link'>$text</a>";
        
    } elseif (is_search ()) {
        _e (
            'Sorry, but nothing matched your search terms. Please try again with some different keywords.',
            'white-turtle'
        );
        
    } else {
        _e (
            'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.',
            'white-turtle'
        );
    }
}

function whiteturtle_post_content_hidden_controls () {
    if (!is_archive () && !is_home () && !is_search ()) {
        return;
    }
    
    echo '<div class="post-content__shadow"></div>';
    echo '<button class="post-content__show"><span class="genericon"></span></button>';
}


function whiteturtle_post_meta_link () {
    if (is_singular () || get_the_title ()) {
        return '';
    }
    
    $link = esc_url (get_permalink ());
    $title = __ ('Go to post', 'white-turtle');
    
    return "<a href='$link' title='$title'>$title</a>";
}

function whiteturtle_post_meta_date () {
    $author = get_the_author_posts_link ();
    $time = get_the_time (get_option ('date_format'));
    
    if ('page' === get_post_type ()) {
        $date = "";
    } elseif ('attachment' === get_post_type ()) {
        $date = "$time";
    } else {
        $date = $author ? "$author - $time" : $time;
    }
    
    return $date;
}

function whiteturtle_post_meta_pagination () {
    $pagination = wp_link_pages (array ( 'echo' => 0 ));
    
    if (!$pagination) {
        return '';
    }
    
    return $pagination;
}

function whiteturtle_post_meta_comments () {
    if (post_password_required () || (!comments_open () && !get_comments_number ())) {
        return '';
    }
    
    ob_start ();
    comments_popup_link (
        '0',
        '1',
        '%'
    );
    
    return whiteturtle_get_icon ('comment') . ' ' . ob_get_clean ();
    
}

function whiteturtle_post_meta_categories () {
    if ('post' !== get_post_type ()) {
        return '';
    }
    
    return '<span class="genericon genericon-category"></span>' . implode (
        ', ',
        array_map (
            function ($value) {
                $title = $value->name;
                $link = get_category_link ($value->term_id);
                
                return "<a href='$link' title='$title'>$title</a>";
            },
            get_the_category ()
        )
    );
}

function whiteturtle_post_meta_tags () {
    if ('post' !== get_post_type () || !get_the_tags ()) {
        return '';
    }
    
    return '<span class="genericon genericon-tag"></span>' . implode (
        ', ',
        array_map (
            function ($value) {
                $title = $value->name;
                $link = get_tag_link ($value->term_id);
                
                return "<a href='$link' title='$title'>$title</a>";
            },
            get_the_tags ()
        )
    );
}


function whiteturtle_post_meta_icon_visibility () {
    global $post;
    
    if (is_sticky ($post->ID) && is_home () && !is_paged ()) {
        return whiteturtle_get_icon ('sticky');
    } elseif (!empty($post->post_password)) {
        return whiteturtle_get_icon ('password');
    } elseif (get_post_status () === 'private') {
        return whiteturtle_get_icon ('private');
    }
    
    return '';
}

function whiteturtle_post_meta_icon_format () {
    $post_format = get_post_format ();
    
    if (!$post_format || 'standard' === $post_format) {
        return '';
    }
    
    $format_link = get_post_format_link ($post_format);
    $format_title = __ (
            'Format: ',
            'white-turtle'
        ) . get_post_format_string ($post_format);
    
    $format_icon = whiteturtle_get_icon ($post_format);
    
    if (!$format_icon) {
        return '';
    }
    
    return "<a href='$format_link' title='$format_title'>$format_icon</a>";
}

function whiteturtle_post_meta_icon_edit () {
    global $post;
    
    if (current_user_can ('edit_post', $post->ID)) {
        $icon = whiteturtle_get_icon ('edit');
        
        ob_start ();
        edit_post_link ($icon);
        
        return ob_get_clean ();
    }
    
    return '';
}

function whiteturtle_post_meta_icon_more () {
    return '<button class="post-meta__show-hidden">' . whiteturtle_get_icon ('more') . '</button>';
}


function whiteturtle_get_post_meta_icons ($more) {
    $icons = array (
        'visibility' => whiteturtle_post_meta_icon_visibility (),
        'format' => whiteturtle_post_meta_icon_format (),
        'edit' => whiteturtle_post_meta_icon_edit (),
    );
    
    if ($more) {
        $icons[ 'more' ] = whiteturtle_post_meta_icon_more ();
    }
    
    return array_filter ($icons);
}

function whiteturtle_get_post_meta () {
    
    $meta_items = array (
        'items' => array (),
        'icons' => array (),
        'hidden_items' => array (),
    );
    
    if (is_singular ()) {
        $meta_items[ 'items' ] = array_filter (
            array (
                'pagination' => whiteturtle_post_meta_pagination (),
                'comments' => whiteturtle_post_meta_comments (),
                'date' => whiteturtle_post_meta_date (),
                'categories' => whiteturtle_post_meta_categories (),
                'tags' => whiteturtle_post_meta_tags (),
            )
        );
        
        $meta_items[ 'icons' ] = whiteturtle_get_post_meta_icons (false);
        
    } elseif (is_search ()) {
        
        $meta_items[ 'items' ] = array_filter (
            array (
                'link' => whiteturtle_post_meta_link (),
                'date' => whiteturtle_post_meta_date (),
                'comments' => whiteturtle_post_meta_comments (),
                'pagination' => whiteturtle_post_meta_pagination (),
            )
        );
        
        $meta_items[ 'hidden_items' ] = array_filter (
            array (
                'categories' => whiteturtle_post_meta_categories (),
                'tags' => whiteturtle_post_meta_tags (),
            )
        );
        
        $meta_items[ 'icons' ] = whiteturtle_get_post_meta_icons ($meta_items[ 'hidden_items' ]);
    } else {
        
        $meta_items[ 'items' ] = array_filter (
            array (
                'link' => whiteturtle_post_meta_link (),
                'date' => whiteturtle_post_meta_date (),
            )
        );
        
        $meta_items[ 'hidden_items' ] = array_filter (
            array (
                'pagination' => whiteturtle_post_meta_pagination (),
                'comments' => whiteturtle_post_meta_comments (),
                'categories' => whiteturtle_post_meta_categories (),
                'tags' => whiteturtle_post_meta_tags (),
            )
        );
        
        $meta_items[ 'icons' ] = whiteturtle_get_post_meta_icons ($meta_items[ 'hidden_items' ]);
    }
    
    return $meta_items;
}

function whiteturtle_get_comments_pagination () {
    $pagination = paginate_comments_links (
        array (
            'echo' => false,
            'prev_next' => false,
            'end_size' => 3,
            'mid_size' => 3,
        )
    );
    
    if (!$pagination) {
        return;
    }
    
    $text_before = 'Pages: ';
    
    echo "<div class='comments-pagination'><span>$text_before</span>$pagination</div>";
}

function whiteturtle_get_comment_meta_author ($comment, $args) {
    $author = get_comment_author_link ($comment);
    
    $parent_comment_id = $comment->comment_parent;
    
    if ($parent_comment_id) {
        $parent_comment = get_comment ($parent_comment_id);
        
        $parent_url = esc_url (get_comment_link ($parent_comment, $args));
        $parent_author = get_comment_author ($parent_comment);
        
        $author .= " " . __ ('to', 'white-turtle') . " <a href='$parent_url'>$parent_author</a>";
    }
    
    return $author;
}

function whiteturtle_get_comment_meta_date ($comment) {
    $time = get_comment_time ('c');
    $date = sprintf (
        __ ('%1$s at %2$s', 'white-turtle'),
        get_comment_date ('', $comment),
        get_comment_time ()
    );
    
    return "<time datetime='$time'>$date</time>";
}

function whiteturtle_get_comment_meta_reply_link ($args, $depth, $comment = null, $post = null) {
    
    $args = array_merge (
        $args,
        array (
            'add_below' => 'div-comment',
            'depth' => $depth,
            'max_depth' => $args[ 'max_depth' ],
            'class_name' => 'comment-meta__reply comment-meta__icon',
            'login_text' => whiteturtle_get_icon ('reply'),
            'reply_text' => whiteturtle_get_icon ('reply'),
        )
    );
    
    $defaults = array (
        'add_below' => 'comment',
        'respond_id' => 'respond',
        'reply_text' => __ ('Reply', 'white-turtle'),
        'reply_to_text' => __ ('Reply to %s', 'white-turtle'),
        'login_text' => __ ('Log in to Reply', 'white-turtle'),
        'depth' => 0,
        'before' => '',
        'class_name' => '',
        'after' => ''
    );
    
    $args = wp_parse_args ($args, $defaults);
    
    if (0 == $args[ 'depth' ] || $args[ 'max_depth' ] <= $args[ 'depth' ]) {
        return '';
    }
    
    $comment = get_comment ($comment);
    
    if (empty($post)) {
        $post = $comment->comment_post_ID;
    }
    
    $post = get_post ($post);
    
    if (!comments_open ($post->ID)) {
        return '';
    }
    
    $class_name = $args[ 'class_name' ];
    
    if (get_option ('comment_registration') && !is_user_logged_in ()) {
        $login_link = esc_url (wp_login_url (get_permalink ()));
        $login_text = $args[ 'login_text' ];
        $login_title = __ ('Log in to Reply', 'white-turtle');
        $link = "<a rel='nofollow' class='comment-reply-login $class_name' href='$login_link' title='$login_title'>$login_text</a>";
    } else {
        $onclick = sprintf (
            'return addComment.moveForm( "%1$s-%2$s", "%2$s", "%3$s", "%4$s" )',
            $args[ 'add_below' ],
            $comment->comment_ID,
            $args[ 'respond_id' ],
            $post->ID
        );
        $reply_to_text = esc_attr (sprintf ($args[ 'reply_to_text' ], $comment->comment_author));
        $reply_text = $args[ 'reply_text' ];
        $reply_link = esc_url (
                add_query_arg ('replytocom', $comment->comment_ID, get_permalink ($post->ID))
            ) . "#" . $args[ 'respond_id' ];
        $link = "<a rel='nofollow' class='comment-reply-link $class_name' href='$reply_link' onclick='$onclick' aria-label='$reply_to_text' title='$reply_to_text'>$reply_text</a>";
    }
    
    if (!$link) {
        return '';
    }
    
    return $link;
}

function whiteturtle_get_comment_meta_edit_link () {
    $link = get_edit_comment_link ();
    
    if (!$link) {
        return '';
    }
    
    $title = __ ('Edit', 'white-turtle');
    $icon = whiteturtle_get_icon ('edit');
    
    return "<a href='$link' title='$title' class='comment-meta__edit comment-meta__icon'>$icon</a>";
}


function bug ($what) {
    echo '<pre>';
    var_dump ($what);
    echo '</pre>';
}