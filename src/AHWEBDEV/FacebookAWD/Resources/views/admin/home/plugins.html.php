<?php
/**
 * Facebook AWD Template
 *
 * @package FacebookAWD
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<div class="facebookAWD">
    <br />
    <ul class="list-group">
        <li class="lists-group-item ">
            <a href="?page=<?php echo $this->container->getSlug(); ?>&master_settings=1" class="btn btn-warning pull-right"><span class="glyphicon glyphicon-cog"></span> Setup</a>
            <h4 class="list-group-item-heading">Facebook AWD</h4>
            <p class="list-group-item-text">Base Facebook AWD container</p>
            <hr />
        </li>

        <?php foreach ($plugins as $plugin) { ?>
            <li class="lists-group-item">
                <a href="?page=<?php echo $plugin->getSlug(); ?>" class="btn btn-default pull-right"><span class="glyphicon glyphicon-cog"></span> Settings</a>
                <h5 class="list-group-item-heading"><?php echo $plugin->getTitle(); ?> <span class="label label-info label-sm"><?php echo $plugin->getVersion(); ?></span></h5>
                <p class="list-group-item-text"><?php echo $plugin->getDescription(); ?></p>
                <p class="list-group-item-text">Author: <?php echo $plugin->getAuthor(); ?></p>
                <hr />
            </li>
        <?php } ?>
    </ul>
    <a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Find more Facebook AWD plugins</a>
</div>
