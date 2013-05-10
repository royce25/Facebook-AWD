<?php
/**
 * Shared Activity Box View
 * @package facebook-awd
 * @var $object AWD_facebook_shared_activitybox
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<div class="AWD_facebook_activitybox">
    <div class="fb-shared-activity"
         data-width="<?php echo $object->getWidth(); ?>"
         data-height="<?php echo $object->getHeight(); ?>"
         data-font="<?php echo $object->getFont(); ?>">
    </div>
</div>