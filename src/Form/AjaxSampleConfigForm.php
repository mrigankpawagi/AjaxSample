<?php

namespace Drupal\ajax_sample\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class AjaxSampleConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ajax_sample_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);
    $config = $this->config('ajax_sample.settings');

    $fields = [
      ['url', 'URL to make AJAX Request to', 'http://example.com/foo?bar=eggs'],
    ];

    for ($i = 0; $i < count($fields); $i++) {
      $form[$fields[$i][0]] = [
        '#type' => 'textfield',
        '#title' => $this->t($fields[$i][1]),
        '#default_value' => $config->get('ajax_sample.' . $fields[$i][0]),
        '#attributes' => [
          'placeholder' => $this->t($fields[$i][2]),
        ],
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = $this->config('ajax_sample.settings');

    $fields = [
      'url',
    ];

    for ($i = 0; $i < count($fields); $i++) {
      $config->set('ajax_sample.' . $fields[$i], $form_state->getValue($fields[$i]));
    }

    $config->save();

    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ajax_sample.settings',
    ];
  }

}
