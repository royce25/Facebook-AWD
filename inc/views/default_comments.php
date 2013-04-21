<?php
    // Do not delete these lines
    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ();

    echo do_shortcode('[AWD_comments url="' . get_permalink($post->ID) . '" ]');
?>