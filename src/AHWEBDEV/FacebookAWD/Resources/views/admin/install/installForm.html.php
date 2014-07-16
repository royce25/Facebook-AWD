<?php
/**
 * Facebook AWD Template
 *
 * @package FacebookAWD
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<?php if (!empty($errors)) { ?>
    <div class="alert alert-danger"><?php echo $errors; ?></div>
<?php } ?>
<?php echo $formView; ?>
