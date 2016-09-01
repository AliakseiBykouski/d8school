<?php

namespace Drupal\lesson3\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Currencies' block.
 *
 * @Block(
 *   id = "lesson3_currencies_block",
 *   admin_label = @Translation("Currencies")
 * )
 */
class Lesson3CurrenciesBlock extends BlockBase {
  public function defaultConfiguration() {
    return array(
      'currencies' => array(),
    );
  }

  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form += parent::buildConfigurationForm($form, $form_state);

    $currency_options = array();
    foreach (\lesson3_currencies_load() as $code => $currency) {
      $currency_options[$code] = $currency->Name;
    }
    $form['currencies'] = array(
      '#type' => 'checkboxes',
      '#title' => $this->t('Currencies'),
      '#options' => $currency_options,
      '#default_value' => $this->configuration['currencies'],
    );

    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $enabled_currencies = $form_state->getValue('currencies');
    foreach ($enabled_currencies as $code => $currency) {
      if (empty($currency)) {
        unset($enabled_currencies[$code]);
      }
    }
    $this->configuration['currencies'] = $enabled_currencies;
  }

  public function build() {
    $currencies = \lesson3_currencies_load();
    $enabled_currencies = array_keys($this->configuration['currencies']);
    $build = array();
    $build['table'] = array(
      '#type' => 'table',
    );

    foreach ($currencies as $code => $currency) {
      if (empty($enabled_currencies) || in_array($code, $enabled_currencies)) {
        $build['table'][$code]['title']['#markup'] = $this->t('!scale !name', array(
          '!scale' => $currency->Scale,
          '!name' => $currency->Name,
        ));
        $build['table'][$code]['rate']['#markup'] = $currency->Rate;
      }
    }

    return $build;
  }
}
