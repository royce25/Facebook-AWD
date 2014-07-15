<?php
/**
 * View Admin template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<?php include dirname(__DIR__) . '/header.html.php'; ?>
<div class="facebookAWD animated fadeInUp">
    <form role="form" id="configuration_wizard" method="post" action="">
        <?php echo $formContent; ?>
        <p class="submit">
            <input type="submit" name="install" id="installawd" class="btn btn-primary animated fadeInUp" value="<?php _e('Install', $this->container->getPtd()); ?>" />
            <?php if ($isReady) { ?>
            <a class="btn btn-default animated fadeInRight" href="?page=<?php echo $this->container->getRoot()->getSlug(); ?>"><?php _e('Cancel', $this->container->getPtd()); ?></a>
            <?php } ?>
        </p>
    </form>
</div>
<script>
    jQuery(document).ready(function ($) {
        $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
        postboxes.add_postbox_toggles('<?php echo get_current_screen()->id; ?>');

        $("#configuration_wizard").validate({
            rules: {
                'fawd_application[id]': {
                    required: true,
                    number: true
                },
                'fawd_application[secretKey]': {
                    required: true,
                    minlength: 10
                }
            },
            //focusCleanup: true,
            errorElement: 'p',
            errorClass: 'text-danger',
            validClass: 'text-success',
            highlight: function (element, errorClass, validClass) {
                if (element.type === "radio") {
                    this.findByName(element.name).addClass(errorClass).removeClass(validClass);
                } else {
                    $(element)
                            .addClass(errorClass)
                            .removeClass(validClass)
                            .parent()
                            .addClass('has-error')
                            .removeClass('has-success');
                }
            },
            unhighlight: function (element, errorClass, validClass) {
                if (element.type === "radio") {
                    this.findByName(element.name).removeClass(errorClass).addClass(validClass);
                } else {
                    $(element)
                            .addClass(validClass)
                            .removeClass(errorClass)
                            .parent()
                            .addClass('has-success')
                            .removeClass('has-error');
                }
            },
            messages: {
                'fawd_application[id]': {
                    required: "The application Id is required, you can find it on your facebook developper dashboard",
                    number: "The application Id must contain only number (123456789...)"
                },
                'fawd_application[secret_key]': {
                    required: "The application Secret Key is required, you can find it on your facebook developper dashboard",
                    minlength: "The application Secret Key seems to be be too short, please verify your settings"
                }
            }
        });
    });
</script>
<?php include dirname(__DIR__) . '/footer.html.php'; ?>
