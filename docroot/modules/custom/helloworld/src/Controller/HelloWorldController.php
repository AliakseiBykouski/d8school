<?php

namespace Drupal\helloworld\Controller;
use Drupal\Core\Controller\ControllerBase;

class HelloWorldController extends ControllerBase {
  
  public function helloWorld() {
    $output = array();
    $output['#title'] = 'Here goes page title';
    $output['content'] = array(
      array(
        '#markup' => '<p>Content first paragraph.</p>',
      ),
      array(
        '#markup' => '<p>This is render array test</p>',
      ),
    );

    return $output;
  }
}
