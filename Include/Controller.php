<?php
/*
 * See LICENSE
 */

class Controller {
  public function render($view, array $data = []) {
    extract($data);

    require_once('Views/' . get_called_class() . '/' . $view . '.php');
  }
}