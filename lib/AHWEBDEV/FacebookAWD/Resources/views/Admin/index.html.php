<?php
/**
 * View Admin template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<div class="wrap facebookAWD container">

    <h1>Facebook AWD</h1>

    <ul id="myTab" class="nav nav-tabs">
        <?php foreach ($menuItems as $key => $menuItem) { ?>
            <li class="<?php echo ($key == 'settings' ? 'active' : ''); ?>">
                <a href="#awd_<?php echo $key; ?>"><?php echo $menuItem['title']; ?></a>
            </li>
        <?php } ?>
    </ul>

    <div class="tab-content">
        <?php foreach ($menuItems as $key => $menuItem) { ?>
            <div class="tab-pane fade <?php echo ($key == 'settings' ? 'in active' : ''); ?>"  id="awd_<?php echo $key; ?>">
                <?php echo $key; ?>
            </div>
        <?php } ?>
    </div>
</div>
</div>
