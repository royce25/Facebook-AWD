<?php 
/*
*
* Interface AWD_facebook_plugin_interface AWD Facebook
* (C) 2012 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
interface AWD_facebook_plugin_interface{
	public function __construct($file,$AWD_facebook);
	public function deactivation();
	public function activation();
	public function old_parent();
	public function missing_parent();
	public function plugin_menu();
	public function plugin_form();
	public function admin_init();
	public function admin_menu();
	public function front_enqueue_js();
	public function admin_enqueue_js();
	public function init();
}
?>