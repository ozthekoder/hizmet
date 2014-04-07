<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Module
 *
 * @author osman
 */
class Module 
{
    public $user;
    public $vars;
    public $view;
    public $css;
    public $js;
    
    public function __construct($user=null) 
    {
        $this->user = $user;
        $this->vars = array();
        $this->css = '';
        $this->js = '';
    }
    
    public function setVar($key, $val)
    {
        $this->vars[$key] = $val;
    }
    
    public function setView($view)
    {
        $this->view = $view;
    }
    
    public function addCSS($css)
    {
        $this->css .= '<link rel="stylesheet" type="text/css" href="' . EventManager::url($css) . '" media="all" />';
    }
    public function addJS($js)
    {
        $this->js .= '<script type="text/javascript" src="' . EventManager::url($js) . '"></script>';
    }
    
    public function createHTML($vars = null)
    {
        if(is_null($vars))
        {
            return $this->view->createHTML($this->vars);
        }
        else
        {
            return $this->view->createHTML($vars);
        }
    }
}
