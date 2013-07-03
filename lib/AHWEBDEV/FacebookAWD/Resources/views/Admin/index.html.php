<?php
/**
 * View Admin template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<style type="text/css">
    body,
    #wpwrap,
    .header_lightbox_help,
    #overlay-content {
        background: linear-gradient(left, rgb(33,113,148) 25%, rgb(21,83,110) 63%, rgb(3,68,98) 82%);
        background: -o-linear-gradient(left, rgb(33,113,148) 25%, rgb(21,83,110) 63%, rgb(3,68,98) 82%);
        background: -moz-linear-gradient(left, rgb(33,113,148) 25%, rgb(21,83,110) 63%, rgb(3,68,98) 82%);
        background: -webkit-linear-gradient(left, rgb(33,113,148) 25%, rgb(21,83,110) 63%, rgb(3,68,98) 82%);
        background: -ms-linear-gradient(left, rgb(33,113,148) 25%, rgb(21,83,110) 63%, rgb(3,68,98) 82%);
        background: -webkit-gradient(
            linear,
            left,
            right top,
            color-stop(0.25, rgb(33,113,148)),
            color-stop(0.63, rgb(21,83,110)),
            color-stop(0.82, rgb(3,68,98))
            );
    }
    #wpfooter{
        background-color: #fff;
        padding: 10px;
        -webkit-border-radius: 10px 10px 0px 0px;
        border-radius: 10px 10px 0px 0px;
    }
    #page{
        background: none;
    }
</style>
<div class="wrap facebookAWD">
    <div id="logo_facebook_awd"></div>
    <div class="navbar primary">
        <div class="navbar-inner">
            <div class="container-fluid">
                <ul class="nav">
                    <?php
                    foreach ($menuItems as $item) {
                        echo '
                            <li class="'.$item['class'].'">
                                <a href="' . $item['url'] . '" title="' . $item['title'] . '">
                                    ' . $item['value'] . '
                                </a>
                            </li>';
                    }
                    ?>
                    <li><a href="http://facebook-awd.ahwebdev.fr/documentation/" target="blank" title="Documentation">Documentation</a></li>
                </ul>
                <form class="navbar-search pull-right" action="http://facebook-awd.ahwebdev.fr/" method="GET" target="_blank">
                    <input type="text" name="s" class="search-query span2" placeholder="Search">
                </form>
            </div>
        </div>
    </div>
    <div class="bgshadow"></div>


    <div id="AWD_facebook_notices">
        <?php
        //do_action('AWD_facebook_admin_notices', true);
        ?>
    </div>

    <h1><?php echo $title; ?></h1>

    <div id="facebookAWD_content" class="row-fluid">

        <div class="span8">
            <div class="well">
                <?php //do_meta_boxes($page_hook, 'normal', null);  ?>
            </div>
        </div>

        <div class="span4">
            <div class="well">

            <?php
            echo $sidebar;
            //do_meta_boxes($page_hook, 'side', null);
            ?>
            </div>
        </div>

    </div>
</div>