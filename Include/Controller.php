<?php
/*
 * See LICENSE
 */

class Controller {
  protected $title = "My App";
  
  public function render($view, array $data = []) {
    extract($data);

    $page_path = 'Views/' . get_called_class() . '/' . $view . '.php';
    require_once('Views/main.php');
  }
}