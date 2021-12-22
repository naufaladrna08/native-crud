<?php
/*
 * Visual Students Router Library
 * Written By Naufal Adriansyah
 * 
 * This source code is open source 
 */

class App {
  protected $controller 	= "home";
  protected $method 		= "__default";
  protected $parameters 	= array();

  public function __construct($controller_path) {
    $url = $this->url_parser();
    
    if (file_exists($controller_path . ucfirst(strtolower($url[0])) . '.php')) {
      $this->controller = strtolower($url[0]);
      unset($url[0]);
    }

    /* Instance Class */
    require_once($controller_path . ucfirst($this->controller) . '.php');
    $this->controller = new $this->controller;
  
    /* Method */
    if (isset($url[1])) {
      if (method_exists($this->controller, $url[1])) {
        $this->method = $url[1];
        unset($url[1]);
      }
    }

    /* Parameters */
    if (!empty($url)) {
      $this->parameters = array_values($url);
    }

    /* Run it! */
    call_user_func_array([$this->controller, $this->method], $this->parameters);
  }

  /* URL Parsing */
  public function url_parser() {
    if (isset($_GET['p'])) {
      $url = rtrim($_GET['p'], '/');
      $url = explode('/', $url);
      return $url;
    }
  }
}