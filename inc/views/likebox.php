<?php
/**
 * Like Box View
 *
 * @package facebook-awd
 * @var $object AWD_facebook_likebutton
 */
?>
<div class="AWD_facebook_likebox">

    <?php if($object->getType() === 'html5'){ ?>

        <div class="fb-like-box"
             data-href="<?php echo $object->getHref(); ?>"
             data-width="<?php echo $object->getWidth(); ?>"
             data-height="<?php echo $object->getHeight(); ?>"
             data-colorscheme="<?php echo $object->getColorscheme(); ?>"
             data-show-faces="<?php echo $object->getShowFaces(); ?>"
             data-border-color="<?php echo $object->getBorderColor(); ?>"
             data-stream="<?php echo $object->getStream(); ?>"
             data-header="<?php echo $object->getHeader(); ?>"
             data-force_wall="<?php echo $object->getForceWall(); ?>">
        </div>

    <?php }else if($object->getType() === 'xfbml'){ ?>

        <fb:like-box
            href="<?php echo $object->getHref(); ?>"
            width="<?php echo $object->getWidth(); ?>"
            height="<?php echo $object->getHeight(); ?>"
            colorscheme="<?php echo $object->getColorscheme(); ?>"
            show-faces="<?php echo $object->getShowFaces(); ?>"
            border-color="<?php echo urlencode($object->getBorderColor()); ?>"
            stream="<?php echo $object->getStream(); ?>"
            header="<?php echo $object->getHeader(); ?>"
            force_wall="<?php echo $object->getForceWall(); ?>">
        </fb:like-box>

    <?php }else if($object->getType() === 'iframe'){ ?>

        <iframe src="http://www.facebook.com/plugins/likebox.php?href=<?php
        echo urlencode($object->getHref());
        ?>&amp;width=<?php echo $object->getWidth();
        ?>&amp;height=<?php echo $object->getHeight();
        ?>&amp;show_faces=<?php echo $object->getShowFaces();
        ?>&amp;header=<?php echo $object->getHeader();
        ?>&amp;colorscheme=<?php echo $object->getColorscheme();
        ?>&amp;border_color=<?php echo urlencode($object->getBorderColor());
        ?>&amp;stream=<?php echo $object->getStream();
        ?>&amp;force_wall=<?php echo $object->getForceWall(); ?>"
        scrolling="no"
        frameborder="0"
        style="border:none; overflow:hidden; width:<?php echo $object->getWidth(); ?>px; height:<?php echo $object->getHeight(); ?>px;" allowTransparency="true"></iframe>

    <?php } ?>

</div>