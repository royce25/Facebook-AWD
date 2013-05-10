<?php
/**
 * Login button View
 * @package facebook-awd
 * @var $object AWD_facebook_loginbutton
 * @var $options array
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */

global $AWD_facebook;
$options = $AWD_facebook->getOptions();

?>
<div class="AWD_facebook_loginbutton">

    <?php
    //search and replace pattern for redirect url
    //@TODO remove those init line to object construct.
    $options['login_redirect_url'] = str_replace(array("%CURRENT_URL%"), array($AWD_facebook->getCurrentUrl()), $options['loginbutton']['login_redirect_url']);
    $options['logout_redirect_url'] = str_replace(array("%CURRENT_URL%"), array($AWD_facebook->getCurrentUrl()), $options['loginbutton']['logout_redirect_url']);


    $displayConnect = $AWD_facebook->isUserLoggedInFacebook() && $options['connect_enable'] && is_user_logged_in();
    ?>

    <?php if ($displayConnect) { ?>
        <?php
        $me = $AWD_facebook->getMe();
        ?>
        <div class="AWD_profile AWD_facebook_wrap">
            <?php if ($object->getShowProfilePicture() == 1 && $object->getShowFaces() == 0) { ?>
                <div class="AWD_profile_image pull-left">
                    <a href="<?php echo $me['link']; ?>" target="_blank" class="thumbnail">
                        <?php echo get_avatar($AWD_facebook->getCurrentUser()->ID, '50'); ?>
                    </a>
                </div>
            <?php } ?>

            <div class="AWD_right">
                <?php if ($object->getShowFaces() == 1) { ?>

                    <div class="AWD_faces">
                        <fb:login-button
                            show-faces="1"
                            width="<?php echo $object->getWidth(); ?>"
                            max-rows="<?php echo $object->getMaxRow(); ?>"
                            size="medium">
                        </fb:login-button>
                    </div>

                <?php } else { ?>

                    <div class="AWD_name">
                        <a href="<?php echo $me['link']; ?>" target="_blank">
                            <?php echo $me['name']; ?>
                        </a>
                    </div>

                <?php } ?>

                <div class="AWD_logout">
                    <a href="<?php echo wp_logout_url($object->getLogoutRedirectUrl()); ?>" class="btn btn-mini btn-danger">
                        <?php echo $object->getLogoutLabel(); ?>
                    </a>
                </div>
            </div>
            <div class="clear"></div>
        </div>

    <?php } else if ($options['connect_enable']) { ?>

        <?php $redirectUrl = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : urlencode($object->getLoginRedirectUrl()); ?>

        <div class="AWD_facebook_login">
            <a href="#" class="AWD_facebook_connect_button" data-redirect="<?php echo $redirectUrl; ?>">
                <img src="<?php echo $object->getImage(); ?>" border="0" alt="Login"/>
            </a>
        </div>

    <?php } else { ?>

        <?php
        if (is_admin()) {
            echo $AWD_facebook->templateManager->displayMessage(sprintf(__('You should enable FB connect in %sApp settings%s', self::PTD), ' <a href="admin.php?page=' . $AWD_facebook::PLUGIN_SLUG . '">', '</a>'), 'warning', false);
        }
        ?>

    <?php } ?>

</div>