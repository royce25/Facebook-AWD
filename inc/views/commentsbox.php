<?php
/**
 * Activity Box View
 * @package facebook-awd
 * @var $object AWD_facebook_commentsbox
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<div class="AWD_facebook_activitybox">

    <?php if ($object->getType() === 'html5') { ?>

        <div class="fb-comments"
             data-href="<?php echo $object->getHref(); ?>"
             data-num-posts="<?php echo $object->getNumPosts(); ?>"
             data-width="<?php echo $object->getWidth(); ?>"
             data-colorscheme="<?php echo $object->getColorscheme(); ?>"
             data-mobile="<?php echo $object->getMobile(); ?>"
             data-order-by="<?php echo $object->getOrderBy(); ?>">
        </div>

    <?php } else if ($object->getType() === 'xfbml') { ?>

        <fb:comments
            href="<?php echo $object->getHref(); ?>"
            num_posts="<?php echo $object->getNumPosts(); ?>"
            width="<?php echo $object->getWidth(); ?>"
            colorscheme="<?php echo $object->getColorscheme(); ?>"
            mobile="<?php echo $object->getMobile(); ?>"
            order_by="<?php echo $object->getOrderBy(); ?>">
        </fb:comments>

    <?php } ?>

</div>