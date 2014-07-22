<?php

/**
 * Facebook AWD
 *
 * This file is part of the facebook AWD package
 * 
 */

namespace AHWEBDEV\FacebookAWD\Listener;

use AHWEBDEV\Framework\ContainerInterface;

/**
 * This is the request listenner
 *
 * This file is used to add some url
 * listener / entry point to wordpress
 * 
 * @package      FacebookAWD
 * @category     Extension
 * @author       Alexandre Hermann <hermann.alexandre@ahwebdev.fr>
 */
class RequestListener
{

    /**
     * The Container used with the listener
     * 
     * @var ContainerInterface
     */
    protected $container;

    /**
     * The current query
     * 
     * @var mixed 
     */
    protected $query;

    /**
     * Conditions
     * 
     * @var arrays 
     */
    protected $conditions;

    /**
     * Constructor
     * 
     * @param \AHWEBDEV\Framework\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->conditions = array();
    }

    /**
     * Init the listener
     */
    public function init()
    {
        add_filter('rewrite_rules_array', array($this, 'insertRewriteRules'));
        add_action('parse_query', array($this, 'parseQuery'));
        add_filter('query_vars', array($this, 'addQueryVars'));
    }

    /**
     * Parse the front end query
     */
    public function parseQuery()
    {
        $this->query = get_query_var($this->container->getSlug());
        if (!empty($this->query) && is_array($this->query)) {
            if (isset($this->query['action'])) {
                //echo $this->container->getSlug() . '_' . $this->query['action'];
                //exit('dd');
                do_action($this->container->getSlug() . $this->query['action'], $this);
            }
        }
    }

    /**
     * Insert Rewrite Rules to front End
     * @param  type $rules
     * @return type
     */
    public function insertRewriteRules($rules)
    {
        $hook = $this->container->getSlug() . '/(' . implode('|', $this->conditions) . ')$';
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
    public function addQueryVars(array $vars)
    {
        $vars[] = $this->container->getSlug();

        return $vars;
    }

    /**
     * Get the conditions path
     * 
     * @return type
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Add a condition path
     * 
     * @param string $condition
     * @return \AHWEBDEV\FacebookAWD\Listener\RequestListener
     */
    public function addCondition($condition)
    {
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * Set the conditions path
     * 
     * @param array $conditions
     * @return \AHWEBDEV\FacebookAWD\Listener\RequestListener
     */
    public function setConditions(array $conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }
    
    /**
     * Get the query
     * 
     * @return array
     */
    public function getQuery()
    {
        return $this->query;
    }
}
