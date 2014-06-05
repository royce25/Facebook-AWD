<?php
/**
 * View Admin template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<div class="wrap">
    <h2>
        <?php echo $this->container->getTitle(); ?> 
        <small><?php echo isset($title) ? str_replace($this->container->getTitle(), "", $title) : ''; ?></small>
    </h2>
    <div id="facebookAWD" class="container">
        <br />
