<?php

namespace Drupal\ga_push\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * GA Push Settings Form.
 */
class GAPushSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ga_push_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ga_push.settings');
    $elements = ga_push_get_methods_option_list(NULL, FALSE);

    $form['google_analytics_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Google Analytics id'),
      'description' => $this->t('This ID is unique to each site you want to track separately, and is in the form of UA-xxxxxxx-yy. To get a Web Property ID, <a href=":analytics">register your site with Google Analytics</a>, or if you already have registered your site, go to your Google Analytics Settings page to see the ID next to every site profile. <a href=":webpropertyid">Find more information in the documentation</a>.', [
        ':analytics' => 'https://marketingplatform.google.com/about/analytics/',
        ':webpropertyid' => Url::fromUri('https://developers.google.com/analytics/resources/concepts/gaConceptsAccounts', ['fragment' => 'webProperty'])
          ->toString(),
      ]),
      '#default_value' => $config->get('google_analytics_id'),
    ];

    $form['ga_push_default_method'] = [
      '#type' => 'radios',
      '#title' => $this->t('Default method'),
      '#options' => $elements,
      '#default_value' => $config->get('default_method'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('ga_push.settings')
      ->set('google_analytics_id', $form_state->getValue('google_analytics_id'))
      ->set('default_method', $form_state->getValue('ga_push_default_method'))
      ->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['ga_push.settings'];
  }

}
