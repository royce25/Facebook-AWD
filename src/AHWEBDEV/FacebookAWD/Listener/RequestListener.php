<?php

namespace AHWEBDEV\FacebookAWD\Listener;

use AHWEBDEV\Framework\ContainerInterface;

/*
 * This file is part of FacebookAWD.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * RequestListener
 *
 * @author Alexandre Hermann <hermann.alexandren@ahwebdev.fr>
 * @package FacebookAWD
 */
class RequestListener
{

    /**
     *
     * @var ContainerInterface
     */
    protected $container;
    protected $query;

    /**
     *
     * @param \AHWEBDEV\Framework\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Init the listener
     */
    public function init()
    {
        //we do not want to add query in admin side
        //use adminInit to do this
        if (is_admin()) {
            return;
        }

        add_filter('rewrite_rules_array', array(&$this, 'insertRewriteRules'));
        add_action('parse_query', array($this, 'parseQuery'));
        add_filter('query_vars', array($this, 'addQueryVars'));
    }

    /**
     * Parse the front end query
     */
    public function parseQuery()
    {
        $this->query = get_query_var($this->container->getSlug());
        if (!empty($this->query)) {
            print_r($this->query);
        }
        exit('Request parser Facebook AWD');
    }

    /**
     * Insert Rewrite Rules to front End
     * @param  type $rules
     * @return type
     */
    public function insertRewriteRules($rules)
    {
        //TODO add a function
        $conditions = array(
            'login',
            'logout',
            'unsync',
            'channel.html',
            'deauthorize',
            'realtime-update-api'
        );
        $hook = $this->container->getSlug() . '/(' . implode('|', $conditions) . ')$';
        $rule = 'index.php?' . $this->container->getSlug() . '[action]=$matches[1]';
        $newrules = array(
            $hook => $rule
        );

        return $newrules + $rules;
    }

    /**
     * Insert a query vars in WP related to the slug of the container
     * @return array
     */
    public function addQueryVars()
    {
        $vars[] = $this->container->getSlug();

        return $vars;
    }

    /**
     * Init the Admin listener
     */
    public function adminInit()
    {

    }

}
