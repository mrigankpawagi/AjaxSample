<?php

namespace Drupal\ajax_sample\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * CONFIG: A page which demonstrates the AJAX 'alert' command.
 */
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

    $form['url'] = [
      '#type' => 'url',
      '#title' => $this->t('URL to make AJAX Request to'),
      '#default_value' => $config->get('ajax_sample.url'),
      '#attributes' => [
        'placeholder' => $this->t('http://example.com/foo?bar=eggs'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('ajax_sample.settings')
      ->set('ajax_sample.url', $form_state->getValue('url'))
      ->save();

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
