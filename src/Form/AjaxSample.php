<?php

namespace Drupal\ajax_sample\Form;

// Substituted AlertCommand with Custom Modal Function
// (use Drupal\Core\Ajax\AlertCommand;)
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityFormInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CommandInterface;

/**
 * Implements hook_form_alter().
 */
function ajax_sample_form_alter(&$form, FormStateInterface $form_state, $ajax_sample_config_form) {
  /* @var Drupal\Core\Entity\FieldableEntityInterface $entity */
  $formObject = $form_state->getFormObject();
  if ($formObject instanceof EntityFormInterface) {
    $entity = $formObject->getEntity();
    if (
      $entity->getEntityTypeId() === 'node'
      && in_array($entity->bundle(), [
        'organisation',
        'location',
        'event',
        'article',
      ])
    ) {
    }
  }
}

/**
 * Custom Command for callback.
 */
class AjaxSampleCommand implements CommandInterface {

  protected $url;

  /**
   * {@inheritdoc}
   */
  public function __construct($url) {
    $this->url = $url;
    $this->level = $level;
  }

  /**
   * {@inheritdoc}
   */
  public function render() {

    return [
      'command' => 'ajaxSampleCommand',
      'url' => $this->url,
    ];
  }

}

/**
 * Custom Command for callback.
 */
class ModalCloseCommand implements CommandInterface {

  /**
   * {@inheritdoc}
   */
  public function render() {

    return [
      'command' => 'modalCloseCommand',
    ];
  }

}

/**
 * A page which demonstrates the AJAX 'alert' command.
 */
class AjaxSample extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ajax_sample';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['modal'] = [
      '#type' => 'container',
      '#id' => 'myAlert',
    ];

    $form['modal']['close'] = [
      '#type' => 'button',
      '#value' => '×',
      '#id' => 'myAlert_close',
      '#ajax' => [
        'callback' => '::modalClose',
        'event' => 'click',
        'progress' => [
          'type' => 'none',
        ],
      ],
    ];

    $form['modal']['content'] = [
      '#type' => 'container',
      '#id' => 'myAlert_content',
    ];

    $form['modal']['content']['result'] = [
      '#type' => 'markup',
      '#markup' => '<a id="myAlert_link" href=""></a><pre id="myAlert_resp"></pre>',
    ];

    $form['details'] = [
      '#type' => 'details',
      '#markup' => 'Click the button below to make the AJAX call.
      To configure the URL for the Ajax Call, go to <a href="ajax/config">/ajax/config</a>',
    ];

    $form['ajax_sample'] = [
      '#type' => 'button',
      '#value' => 'Make AJAX Call',
      '#id' => 'ajaxBtn',
      '#ajax' => [
        'callback' => '::ajaxCallback',
        'event' => 'click',
        'progress' => [
          'type' => 'throbber',
          'message' => 'Fetching...',
        ],
      ],
    ];

    $form['#attached']['library'][] = 'ajax_sample/ajaxPage';
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function ajaxCallback($form, $form_state) {

    $response = new AjaxResponse();
    $response->addCommand(new ajaxSampleCommand(\Drupal::config('ajax_sample.settings')->get('ajax_sample.url')));
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function modalClose($form, $form_state) {

    $response = new AjaxResponse();
    $response->addCommand(new modalCloseCommand());
    return $response;
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
