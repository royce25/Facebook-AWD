<?php

/**
 * View Admin template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
use AHWEBDEV\FacebookAWD\FacebookAWD;
?>
<?php if (!empty($errors)) { ?>
    <div class="alert alert-danger"><?php echo $errors; ?></div>
<?php } ?>
<?php echo $formView; ?>