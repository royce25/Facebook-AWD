<?php

use AHWEBDEV\Form;

/**
 * View Admin settgins template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
$form = new Form('form_settings', 'POST', '', self::OPTION_PREFIX);
?>
<div id="div_options_content">
    <?php echo $form->start(); ?>
    <div id="settings" class="tabbable tabs-left">
        <ul id="settings_menu" class="nav nav-tabs">
            <?php if (current_user_can('manage_facebook_awd_settings')) { ?>
                <li><a href="#general" data-toggle="tab">General</a></li>
                <li><a href="#fbconnect" data-toggle="tab">Facebook Connect</a></li>
                <li><a href="#opengraph" data-toggle="tab">OpenGraph</a></li>
            <?php } ?>
            <?php if (current_user_can('manage_facebook_awd_publish_to_pages')) { ?>
                <li><a href="#managepages" data-toggle="tab">Manage Pages</a></li>
            <?php } ?>
        </ul>
        <div class="tab-content">
            <?php if (current_user_can('manage_facebook_awd_settings')) { ?>
                <div id="general" class="tab-pane">
                    <div class="row">
                        <?php
                        echo $form->addInputText(__('App ID (facebook)', self::PTD), 'app_id', $this->options['app_id'], 'span4', array(
                            'class' => 'span3'), 'icon-barcode');
                        echo $form->addInputText(__('App SECRET KEY', self::PTD), 'app_secret_key', $this->options['app_secret_key'], 'span4', array(
                            'class' => 'span3'), 'icon-barcode');
                        echo $form->addInputText(__('Admin IDs', self::PTD), 'admins', $this->options['admins'], 'span4', array(
                            'class' => 'span3'), 'icon-barcode');
                        ?>
                        <div class="span4">
                            <div class="row">
                                <?php
                                echo $form->addInputText(__('Locale', self::PTD), 'locale', $this->options['locale'], 'span2', array(
                                    'class' => 'span1'), 'icon-flag');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="opengraph" class="tab-pane">
                    <div class="row">
                        <?php
                        echo $form->addSelect(__('Activate Open Graph ?', self::PTD), 'open_graph_enable', array(
                            array(
                                'value' => 0,
                                'label' => __('No', self::PTD)),
                            array(
                                'value' => 1,
                                'label' => __('Yes', self::PTD) . ' ' . __('(recommended)', self::PTD))
                                ), $this->options['open_graph_enable'], 'span3', array(
                            'class' => 'span3'));
                        ?>
                    </div>
                </div>

                <div id="fbconnect" class="tab-pane">
                    <h1><?php _e("Facebook Connect", self::PTD); ?></h1>
                    <div class="row">
                        <?php
                        echo $form->addSelect(__('Activate FB Connect ?', self::PTD), 'connect_enable', array(
                            array(
                                'value' => 0,
                                'label' => __('No', self::PTD)),
                            array(
                                'value' => 1,
                                'label' => __('Yes', self::PTD))
                                ), $this->options['connect_enable'], 'span3', array(
                            'class' => 'span3'));

                        echo $form->addSelect(__('Add FB avatar choice ?', self::PTD), 'connect_fbavatar', array(
                            array(
                                'value' => 0,
                                'label' => __('No', self::PTD)),
                            array(
                                'value' => 1,
                                'label' => __('Yes', self::PTD))
                                ), $this->options['connect_fbavatar'], 'span3', array(
                            'class' => 'span3 depend_fb_connect',
                            'disabled' => $this->options['connect_enable'] == '0' ? 'disabled' : ''));
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        echo $form->addInputText(__('Facebook Connect permissions', self::PTD), 'perms', $this->options['perms'], 'span3', array(
                            'class' => 'span3 depend_fb_connect',
                            'disabled' => $this->options['connect_enable'] == '0' ? 'disabled' : ''));

                        echo $form->addInputText(__('Timeout Facebook connect API', self::PTD), 'timeout', $this->options['timeout'], 'span3', array(
                            'class' => 'span3 depend_fb_connect',
                            'disabled' => $this->options['connect_enable'] == '0' ? 'disabled' : ''));
                        ?>
                    </div>
                    <br />
                    <h1><?php _e("Facebook Realtime API", self::PTD); ?></h1>

                    <div class="alert alert-info">
                        <?php _e("This plugin can keep user data sync in realtime when they change on the facebook side. Normally the plugin wait the user loggin action to fetch new data. If you want to use this feature, you must configure the realtime api in your facebook application settings, on the facebook developer website.", self::PTD); ?>
                        <a target="_blank" href="https://developers.facebook.com/docs/reference/api/realtime/" class="btn btn-mini btn-info"><?php _e("Learn more", self::PTD); ?></a>
                    </div>

                    <label><?php _e("Configure the realtime API", self::PTD); ?></label>
                    <p><small><i class="icon-warning-sign"></i> <?php _e("The plugin only supports User fields and permissions subscriptions.", self::PTD); ?></small></p>
                    <ol>
                        <li>
                            <a href="https://developers.facebook.com/apps/<?php echo $this->options['app_id']; ?>/realtime" class="btn btn btn-mini" target="_blank">
                                <i class="icon-cog"></i> <?php _e("Go on the Subscriptions page", self::PTD); ?>
                            </a>
                        </li>
                        <li><?php _e("Click on the Add button and Select the subscription to create", self::PTD); ?></li>
                        <li><?php _e("Add fields name you want to follow", self::PTD); ?></li>
                        <li><?php _e("Set the callback url, you should use the callback url provided on this page.", self::PTD); ?></li>
                        <li><?php _e("Set the verify token, you should use the token provided on this page.", self::PTD); ?></li>
                        <li><?php _e("Click on Test to check the configuration, if success it's done Validate the form. If no, check your configuration again.", self::PTD); ?></li>
                        <li><?php _e("Come back here, reload the page and check subscriptions list.", self::PTD); ?></li>
                    </ol>

                    <label><?php _e("Your Callback url", self::PTD); ?></label>
                    <i class="icon-share"></i> <a href="<?php echo $this->_realtime_api_url; ?>"><?php echo $this->_realtime_api_url; ?></a></p>

                    <label><?php _e("Verify Token", self::PTD); ?></label>
                    <i class="icon-share"></i> <code><?php echo md5($this->options['app_id']); ?></code></p>
                    <h4><?php _e("Subscriptions detected:", self::PTD); ?></h4>
                    <?php
                    $subscriptions = $this->getRealtimeSubscriptions();
                    if (!is_wp_error($subscriptions)) {
                        ?>
                        <?php if (count($subscriptions)) { ?>
                            <div class="row">
                                <?php
                                foreach ($subscriptions as $sub) {
                                    $class = "success";
                                    if (!$sub['active'])
                                        $class = "error";
                                    if ($this->_realtime_api_url != $sub['callback_url'])
                                        $class = "error";
                                    echo '
                                    <div class="span3 list_item">
                                        <h2>' . ucfirst($sub['object']) . '
                                        ' . ($this->_realtime_api_url != $sub['callback_url'] ? '<span class="label label-' . $class . ' pull-right">' . __("Callback url not match", self::PTD) . '</span>' : '') . '
                                        <span class="pull-right label label-' . ($sub['active'] ? 'success' : 'error') . '">' . ($sub['active'] ? __("Active", self::PTD) : __("Disabled", self::PTD)) . '</span>
                                        </h2>
                                        <div class="thumbnail">
                                            <label>' . __("Fields", self::PTD) . ' <i class="icon-tags"></i>  </label><span class="badge badge-info">' . rtrim(implode('</span> <span class="badge badge-info">', $sub['fields']), ', ') . '</span>
                                            <p><label>' . __("Callback Url", self::PTD) . ' <i class="icon-share"></i> </label><small><a href="' . $sub['callback_url'] . '">' . $sub['callback_url'] . '"</a></small></p>
                                        </div>
                                    </div>';
                                }
                                ?>
                            </div>
                            <?php
                        }else {
                            $this->templateManager->displayMessage(__("No Realtime subscription", self::PTD), "info");
                        }
                    } else {
                        $this->templateManager->displayMessage($subscriptions->get_error_message(), "warning");
                    }
                    ?>
                </div>
            <?php } ?>

            <?php if (current_user_can('manage_facebook_awd_publish_to_pages')) { ?>
                <div id="managepages" class="tab-pane">
                    <?php
                    if ($this->options['connect_enable'] == 0) {
                        $this->templateManager->displayMessage(sprintf(__('Facebook connect is required to manage pages %sRetry%s', self::PTD), '<a class="btn btn-danger" href="' . $this->getCurrentUrl() . '">', '</a>'), 'error');
                    } else {
                        if ($this->currentFacebookUserCan('publish_stream')) {
                            $this->templateManager->displayMessage(__('Publish Stream is enabled', self::PTD), 'success');
                        } else {
                            echo '<a href="#" data-scope="email,publish_stream" class="getPermissions btn btn-info"><i class="icon-ok-sign icon-white"></i> ' . __('Authorize App to publish on your pages', self::PTD) . '</a>';
                        }

                        if ($this->currentFacebookUserCan('manage_pages')) {
                            $message = __('Pages can be managed', self::PTD) . ' <a href="#" id="toogle_list_pages" class="btn btn-info"><i class="icon-check icon-white"></i> ' . __('Select pages to link with Wordpress', self::PTD) . '</a>';
                            $this->templateManager->displayMessage($message, 'success');
                        } else {
                            echo '<a href="#" data-scope="email,manage_pages" class="getPermissions btn btn-info"><i class="icon-ok-sign icon-white"></i> ' . __('Authorize App to access your pages', self::PTD) . '</a>';
                        }

                        if ($this->currentFacebookUserCan('manage_pages') && $this->isUserLoggedInFacebook()) {
                            ?>
                            <div class="toogle_fb_pages hidden well">
                                <h2><?php _e('Check the page you want to sync with your posts.', self::PTD); ?></h2>
                                <?php

                                $fb_pages = isset($this->me['pages']) ? $this->me['pages'] : array();
                                if (is_array($fb_pages) AND count($fb_pages)) {
                                    echo '
                                    <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>' . __('Publish on ?', self::PTD) . '</th>
                                            <th>' . __('Picture', self::PTD) . '</th>
                                            <th>' . __('Name', self::PTD) . '</th>
                                            <th>' . __('ID', self::PTD) . '</th>
                                            <th>' . __('Category', self::PTD) . '</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    foreach ($fb_pages as $fb_page) {
                                        if ($fb_page['category'] == 'Application')
                                            continue;
                                        $value = isset($this->options['fb_publish_to_pages'][$fb_page['id']]) ? $this->options['fb_publish_to_pages'][$fb_page['id']] : 0;
                                        $select = $form->addSelect('', 'fb_publish_to_pages[' . $fb_page['id'] . ']', array(
                                            array(
                                                'value' => 0,
                                                'label' => __('No', self::PTD)),
                                            array(
                                                'value' => 1,
                                                'label' => __('Yes', self::PTD))
                                                ), $value, 'span2', array(
                                            'class' => 'span2'));
                                        echo '
                                        <tr>
                                            <td>' . $select . '</td>
                                            <td><a href="#" class="thumbnail"><img class="fb_pages_picto" src="http://graph.facebook.com/' . $fb_page['id'] . '/picture" width="30" height="30" /></a></td>
                                            <td>' . $fb_page['name'] . '</td>
                                            <td>' . $fb_page['id'] . '</td>
                                            <td>' . $fb_page['category'] . '</td>
                                        </tr>';
                                    }
                                    echo '</tbody>
                                    </table>';
                                }
                                ?>
                            </div>
                        <?php } ?>
                        <?php if ($this->currentFacebookUserCan('publish_stream') && current_user_can('manage_facebook_awd_settings')) { ?>
                            <div class="row">
                                <?php
                                if ($this->currentFacebookUserCan('manage_pages')) {
                                    echo $form->addSelect(__('Auto publish post on Facebook pages ?', self::PTD), 'publish_to_pages', array(
                                        array(
                                            'value' => 0,
                                            'label' => __('No', self::PTD)),
                                        array(
                                            'value' => 1,
                                            'label' => __('Yes', self::PTD))
                                            ), $this->options['publish_to_pages'], 'span3', array(
                                        'class' => 'span3'));
                                }

                                echo $form->addSelect(__('Auto publish post on Facebook profile ?', self::PTD), 'publish_to_profile', array(
                                    array(
                                        'value' => 0,
                                        'label' => __('No', self::PTD)),
                                    array(
                                        'value' => 1,
                                        'label' => __('Yes', self::PTD))
                                        ), $this->options['publish_to_profile'], 'span3', array(
                                    'class' => 'span3'));
                                ?>
                            </div>
                            <div class="row">
                                <?php
                                echo $form->addInputText(__('Default link action Text', self::PTD), 'publish_read_more_text', $this->options['publish_read_more_text'], 'span3', array(
                                    'class' => 'span3',
                                    'maxlengh' => '25'));
                                ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>


        </div>
    </div>
    <?php wp_nonce_field(self::PLUGIN_SLUG . '_update_options', self::OPTION_PREFIX . '_nonce_options_update_field'); ?>
    <div class="form-actions">
        <a href="#" id="submit_settings" class="btn btn-primary" data-loading-text="<i class='icon-time icon-white'></i> <?php _e('Saving settings...', self::PTD); ?>"><i class="icon-cog icon-white"></i> <?php _e('Save all settings', self::PTD); ?></a>
        <?php if (current_user_can('manage_facebook_awd_settings')) { ?>
            <a href="#" id="reset_settings" class="btn btn-danger" data-loading-text="<i class='icon-time icon-white'></i> <?php _e('Waiting for your anwser', self::PTD); ?>"><i class="icon-trash icon-white"></i> <?php _e('Restore defaults settings', self::PTD); ?></a>
        <?php } ?>
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZQ2VL33YXHJLC" class="awd_tooltip_donate btn pull-right" id="help_donate" target="_blank" class="btn pull-right"><i class="icon-heart"></i> <?php _e('Donate!', self::PTD); ?></a>
    </div>
    <?php
    echo $form->end();

    //reset form
    if (current_user_can('manage_facebook_awd_settings')) {
        $form_reset = new AWD_facebook_form('reset_settings', 'POST', '', self::OPTION_PREFIX);
        echo $form_reset->start();
        wp_nonce_field(self::PLUGIN_SLUG . '_reset_options', self::OPTION_PREFIX . '_nonce_reset_options');
        echo $form_reset->end();
    }
    ?>
</div>
<?php if (current_user_can('manage_facebook_awd_settings')) { ?>
    <div class="alert alert-error alert_reset_settings alert-block dn">
        <a href="#" class="close reset_settings_dismiss">&times;</a>
        <?php _e("Do you really want to reset all settings (AWD plugins and openGraph settings will be reset) ?", self::PTD); ?>
        <a href="#" class="btn btn-danger reset_settings_confirm"><?php _e("Restore", self::PTD); ?></a>
    </div>
<?php } ?>