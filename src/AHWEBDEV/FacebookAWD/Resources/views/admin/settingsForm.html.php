<?php
/**
 * Facebook AWD Template
 *
 * @package FacebookAWD
 * @subpackage FacebookAWD
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
if (!function_exists('createSection_awdTemplate')) {

    function createSection_awdTemplate($sections)
    {
        foreach ($sections as $section => $content) {
            ?>
            <div class="section_<?php echo $section; ?>"><?php
                if (is_array($content)) {
                    echo createSection_awdTemplate($content);
                } else {
                    echo $content;
                }
                ?>
            </div>
            <?php
        }
    }

}
?>
<div class="facebookAWD <?php echo $classes; ?>">
    <?php if (!empty($success)) { ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php } ?>
    <form role="form" id="configuration_wizard" method="post" action="">
        <?php if (!empty($errors)) { ?>
            <div class="alert alert-danger"><?php echo $errors; ?></div>
        <?php } ?>
        <?php createSection_awdTemplate($sections); ?>
        <?php if ($withSubmit) { ?>
            <input type="submit" name="submit" id="submit_settings" class="btn btn-primary btn-mini" value="<?php _e('Save', $this->container->getPtd()); ?>" />
        <?php } ?>
    </form>
</div>
