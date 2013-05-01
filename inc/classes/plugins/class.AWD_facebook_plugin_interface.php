<?php 
/**
 * 
 * @author alexhermann
 *
 */

interface AWD_facebook_plugin_interface{
	public function __construct($file,$AWD_facebook);
	public function init();
	public function getVersion();
	public function oldParent();
	public function missingParent();
	public function missingFacebookConnect();
	public function defaultOptions($options);
	public function registerWidgets();

	public function adminInit();
	public function adminMenu();
	public function adminForm();
	
	public function pluginSettingsMenu($list);
	public function pluginSettingsForm($fields);
	
	public function frontEnqueueJs();
	public function frontEnqueueCss();
	public function adminEnqueueJs();
	public function adminEnqueueCss();
	public function globalEnqueueJs();
	public function globalEnqueueCss();
	public function handlePostUpdate();
	public function jsVars($vars);
	
}
?>