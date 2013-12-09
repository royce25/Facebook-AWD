<?php
/**
 * View Admin template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<div id="facebookAWD" class="wrap container">
    <div class="page-header">
        <h2>Facebook AWD <small>Configuration Wizard</small></h2>
    </div>
    <form role="form" id="configuration_wizard" method="post" action="">
        <div class="panel panel-default">
            <div class="panel-heading">Facebook Applcation</div>
            <div class="panel-body">
                <?php if ($error) { ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>
                <?php echo $formView; ?>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="?page=FacebookAWD" class="btn btn-default">Cancel</button>
        <input type="hidden" name="page" value="FacebookAWD" />
    </form>
</div>
<script>
    jQuery(document).ready(function($) {
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
            highlight: function(element, errorClass, validClass) {
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
            unhighlight: function(element, errorClass, validClass) {
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