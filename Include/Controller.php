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

  public function json($data = []) {
    return print_r(json_encode($data));
  }

  public function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
      'y' => 'year',
      'm' => 'month',
      'w' => 'week',
      'd' => 'day',
      'h' => 'hour',
      'i' => 'minute',
      's' => 'second',
    );

    foreach ($string as $k => &$v) {
      if ($diff->$k) {
        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
      } else {
        unset($string[$k]);
      }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
  }
}