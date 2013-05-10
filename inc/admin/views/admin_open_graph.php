<?php
/**
 * View Admin opengraph template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<div id="div_options_content">
    <div id="settings_ogp" class="tabbable tabs-left">
        <div class="tab-content">
            <div id="ogtags_objects">
                <h1><?php _e('Create Objects', self::PTD); ?></h1>
                <?php $ogp_objects = apply_filters('AWD_facebook_ogp_objects', $this->options['opengraph_objects']); ?>
                <table class="table table-bordered awd_list_opengraph_object">
                    <thead>
                    <th>Title</th>
                    <th><span class="pull-right">Actions</span></th>
                    </thead>
                    <tbody class="content">
                        <?php
                        if (is_array($ogp_objects) && count($ogp_objects)) {
                            foreach ($ogp_objects as $ogp_object) {
                                echo $this->getOpengraphObjectListItem($ogp_object);
                            }
                        }
                        echo '<tr class="awd_no_objects ' . (is_array($ogp_objects) && count($ogp_objects) ? 'hidden' : '') . '">
							<td colspan="2">' . $this->templateManager->displayMessage(__('No Object found', self::PTD), 'warning', false) . '</td>
						  </tr>';
                        ?>
                    </tbody>
                    <tfoot>
                        <tr><td colspan="2"><button class="btn btn-success pull-right show_ogp_form" data-loading-text="<?php _e('Editing...', self::PTD); ?>"><i class="icon-plus icon-white"></i> <?php _e('Add an object', self::PTD); ?></button></td></tr>
                    </tfoot>
                </table>

                <div class="hidden awd_ogp_form well">
                </div>

                <h1><?php _e('Define Objects relation', self::PTD); ?></h1>
                <div class="awd_ogp_links">
                    <?php echo $this->getOpengraphObjectLinksForm(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <a href="#" id="submit_ogp" class="btn btn-primary" data-loading-text="<i class='icon-time icon-white'></i> <?php _e('Saving settings...', self::PTD); ?>"><i class="icon-cog icon-white"></i> <?php _e('Save all settings', self::PTD); ?></a>
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZQ2VL33YXHJLC" class="awd_tooltip_donate btn pull-right" id="help_donate" target="_blank" class="btn pull-right"><i class="icon-heart"></i> <?php _e('Donate!', self::PTD); ?></a>
    </div>
</div>