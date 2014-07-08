<?php
/**
 * View Admin template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<div class="facebookAWD">
    <?php if (!empty($success)) { ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php } ?>
    <form role="form" id="configuration_wizard" method="post" action="">
        <?php if (!empty($errors)) { ?>
            <div class="alert alert-danger"><?php echo $errors; ?></div>
        <?php } ?>
        <?php foreach ($sections as $section => $content) { ?>
            <div class="section_<?php echo $section; ?>">
                <?php echo $content; ?>
            </div>
        <?php } ?>
        <input type="submit" name="submit" id="submit_settings" class="btn btn-primary btn-mini" value="<?php _e('Save', $this->container->getPtd()); ?>" />
    </form>
</div>

