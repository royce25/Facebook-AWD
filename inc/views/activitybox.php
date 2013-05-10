<?php
/**
 * Activity Box View
 * @package facebook-awd
 * @var $object AWD_facebook_activitybox
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<div class="AWD_facebook_activitybox">

    <?php if ($object->getType() === 'html5') { ?>

        <div class="fb-activity"
             data-site="<?php echo $object->getDomain(); ?>"
             data-width="<?php echo $object->getWidth(); ?>"
             data-height="<?php echo $object->getHeight(); ?>"
             data-header="<?php echo $object->getHeader(); ?>"
             data-colorscheme="<?php echo $object->getColorscheme(); ?>"
             data-linktarget="<?php echo $object->getLinktarget(); ?>"
             data-border-color="<?php echo $object->getBorderColor(); ?>"
             data-font="<?php echo $object->getfont(); ?>"
             data-recommendations="<?php echo $object->getRecommendations(); ?>"
             data-max_age="<?php echo $object->getMaxAge(); ?>"
             data-ref="<?php echo $object->getRef(); ?>"
             data-filter="<?php echo $object->getFilter(); ?>">
        </div>

    <?php } else if ($object->getType() === 'xfbml') { ?>

        <fb:activity
            site="<?php echo $object->getDomain(); ?>"
            width="<?php echo $object->getWidth(); ?>"
            height="<?php echo $object->getHeight(); ?>"
            header="<?php echo $object->getHeader(); ?>"
            colorscheme="<?php echo $object->getColorscheme(); ?>"
            linktarget="<?php echo $object->getLinktarget(); ?>"
            border-color="<?php echo $object->getBorderColor(); ?>"
            font="<?php echo $object->getfont(); ?>"
            recommendations="<?php echo $object->getRecommendations(); ?>"
            max_age="<?php echo $object->getMaxAge(); ?>"
            ref="<?php echo $object->getRef(); ?>"
            filter="<?php echo $object->getFilter(); ?>">
        </fb:activity>

    <?php } else if ($object->getType() === 'iframe') { ?>

        <iframe
            src="http://www.facebook.com/plugins/activity.php?site=<?php
        echo $object->getDomain();
        ?>&amp;width=<?php echo $object->getWidth();
        ?>&amp;height=<?php echo $object->getHeight();
        ?>&amp;header=<?php echo $object->getHeader();
        ?>&amp;colorscheme=<?php echo $object->getColorscheme();
        ?>&amp;border_color=<?php echo urlencode($object->getBorderColor());
        ?>&amp;recommendations=<?php echo $object->getRecommendations();
        ?>&amp;linktarget=<?php echo $object->getLinktarget();
        ?>&amp;max_age=<?php echo $object->getMaxAge();
        ?>&amp;ref=<?php echo $object->getRef();
        ?>&amp;filter=<?php echo $object->getFilter(); ?>"
            scrolling="no"
            frameborder="0"
            style="border:none; overflow:hidden; width:<?php echo $object->getWidth(); ?>px; height:<?php echo $object->getHeight(); ?>px;"
            allowTransparency="true">
        </iframe>

    <?php } ?>

</div>