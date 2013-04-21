<?php
/**
 * Like Button View
 *
 * @package facebook-awd
 * @var $object AWD_facebook_likebutton
 */
?>
<div class="AWD_facebook_likebutton">

    <?php if($object->getType() === 'html5'){ ?>

        <div class="fb-like"
             data-href="<?php echo $object->getHref(); ?>"
             data-send="<?php echo $object->getSend(); ?>"
             data-layout="<?php echo $object->getLayout(); ?>"
             data-width="<?php echo $object->getWidth(); ?>"
             data-show-faces="<?php echo $object->getShowFaces(); ?>"
             data-action="<?php echo $object->getAction(); ?>"
             data-colorscheme="<?php echo $object->getColorscheme(); ?>"
             data-font="<?php echo $object->getFont(); ?>"
             data-ref="<?php echo $object->getRef(); ?>">
        </div>

    <?php }else if($object->getType() === 'xfbml'){ ?>

        <fb:like
            href="<?php echo $object->getHref(); ?>"
            send="<?php echo $object->getSend(); ?>"
            width="<?php echo $object->getWidth(); ?>"
            colorscheme="<?php echo $object->getColorscheme(); ?>"
            layout="<?php echo $object->getlayout(); ?>"
            show_faces="<?php echo $object->getShowFaces(); ?>"
            font="<?php echo $object->getFont(); ?>"
            action="<?php echo $object->getAction(); ?>"
            ref="<?php echo $object->getHref(); ?>">
        </fb:like>

    <?php }else if($object->getType() === 'iframe'){ ?>

        <iframe
            src="http://www.facebook.com/plugins/like.php?href=<?php
            echo urlencode($object->getHref());
            ?>&amp;send=<?php
            echo $object->getSend();
            ?>&amp;layout=<?php
            echo $object->getLayout();
            ?>&amp;width=<?php
            echo $object->getWidth();
            ?>&amp;show_faces=<?php
            echo $object->getShowFaces();
            ?>&amp;action=<?php
            echo $object->getAction();
            ?>&amp;colorscheme=<?php
            echo $object->getColorscheme();
            ?>&amp;font=<?php
            echo $object->getFont();
            ?>&amp;height=<?php
            echo $object->getHeight();
            ?>&ref=<?php
            echo urlencode($object->getRef());
            ?>"
            scrolling="no"
            frameborder="0"
            style="border:none; overflow:hidden; width:<?php echo $object->getWidth(); ?>px; height:<?php echo $object->getHeight(); ?>px;"
            allowTransparency="true">
        </iframe>

    <?php } ?>

</div>