<?php
/**
 * Created by PhpStorm.
 * User: Aliaksei_Bykouski
 * Date: 8/29/2016
 * Time: 5:41 PM
 */

namespace Drupal\lesson3\Controller;
use Drupal\Core\Controller\ControllerBase;

class CurrenciesController extends ControllerBase {
  public function content() {
    $output = array();

    $output['table'] = array(
      '#type' => 'table',
    );

    $currencies = \lesson3_currencies_load();
    if (!empty($currencies)) {
      foreach ($currencies as $code => $currency) {
        $output['table'][$code]['code']['#markup'] = $currency->CharCode;
        $output['table'][$code]['title']['#markup'] = $this->t('!scale !name', array(
          '!scale' => $currency->Scale,
          '!name' => $currency->Name,
        ));
        $output['table'][$code]['rate']['#markup'] = $currency->Rate;
      }
    }

    $output['debug'] = array(
      '#prefix' => '<pre>',
      '#markup' => var_export($currencies, TRUE),
      '#suffix' => '</pre>',
      '#weight' => 100,
    );

    return $output;
  }
}
