<?php
/**
 * View Comments template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die();

echo do_shortcode('[AWD_facebook_commentsbox href="' . get_permalink($post->ID) . '" ]');
?>