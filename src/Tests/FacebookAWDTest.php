<?php

namespace AHWEBDEV\FacebookAWD\Tests;

use AHWEBDEV\FacebookAWD\FacebookAWD;

class FacebookAWDTest extends \WP_UnitTestCase
{

    /**
     * @var FacebookAWD
     */
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = getFacebookAWD();
    }

    /**
     * @covers AHWEBDEV\FacebookAWD\FacebookAWD::initServices
     * @todo   Implement testInitServices().
     */
    public function testInitServices()
    {
        $servicesNames = array(
            'services.template_manager',
            'services.option_manager',
            //'services.facebook.app',//init the test app
            'services.facebook.client',
            'admin'
        );
        foreach ($servicesNames as $name) {
            if (!$this->object->has($name)) {
                echo $name;
            }
            $this->assertTrue($this->object->has($name));
        }
    }

    /**
     * @covers AHWEBDEV\FacebookAWD\FacebookAWD::initListeners
     * @todo   Implement testInitListeners().
     */
    public function testInitListeners()
    {
        $this->assertTrue($this->object->has('listener.request_listener'));
    }

    /**
     * @covers AHWEBDEV\FacebookAWD\FacebookAWD::initControllers
     * @todo   Implement testInitControllers().
     */
    public function testInitControllers()
    {
        $servicesNames = array(
            'controller.backend',
            'controller.install',
            'controller.front'
        );

        foreach ($servicesNames as $name) {
            $this->assertTrue($this->object->has($name));
        }
    }

    /**
     * @covers AHWEBDEV\FacebookAWD\FacebookAWD::registerAssets
     * @todo   Implement testRegisterAssets().
     */
    public function testRegisterAssets()
    {
        $assets = $this->object->getAssets();

        $this->object->registerAssets();

        //test scripts
        global $wp_scripts;
        foreach ($assets['script'] as $id => $data) {
            $this->assertTrue(array_key_exists($id, $wp_scripts->registered));
        }

        //test styles
        global $wp_styles;
        foreach ($assets['style'] as $id => $data) {
            $this->assertTrue(array_key_exists($id, $wp_styles->registered));
        }
    }

    /**
     * @covers AHWEBDEV\FacebookAWD\FacebookAWD::launch
     * @todo   Implement testLaunch().
     */
    public function testLaunch()
    {
        $hasActionAdminInit = has_action('admin_init', array($this->object->get('admin'), 'adminInit'));
        $this->assertGreaterThan(0, $hasActionAdminInit);

        //install controller as we do not have application set in database
        $hasActionAdminMenu = has_action('admin_menu', array($this->object->get('controller.install'), 'adminMenu'));
        $this->assertGreaterThan(0, $hasActionAdminMenu);
    }

    /**
     * @covers AHWEBDEV\FacebookAWD\FacebookAWD::getTokenFormConfig
     * @todo   Implement testGetTokenFormConfig().
     */
    public function testGetTokenFormConfig()
    {
        $tokenConfig = $this->object->getTokenFormConfig();
        $this->assertTrue((bool) wp_verify_nonce($tokenConfig['token']['value'], 'fawd-token'));
    }

    /**
     * @covers AHWEBDEV\FacebookAWD\FacebookAWD::boot
     * @todo   Implement testBoot().
     */
    public function testBoot()
    {
        $instance = FacebookAWD::boot();
        $this->assertTrue($instance instanceof FacebookAWD);
    }

}
