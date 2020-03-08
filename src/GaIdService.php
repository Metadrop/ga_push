<?php

namespace Drupal\ga_push;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Class GaIdService.
 */
class GaIdService implements GaIdServiceInterface {

  /**
   * Drupal\Core\Config\ConfigManagerInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs a new AnalyticsIdService object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_manager
   *   Configuration manager.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   Module handler service.
   */
  public function __construct(ConfigFactoryInterface $config_manager, ModuleHandlerInterface $module_handler) {
    $this->configFactory = $config_manager;
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public function getAnalyticsId() {
    $ga_push = $this->configFactory->get('ga_push.settings');
    $google_analytics_id = $ga_push->get('google_analytics_id');

    if (empty($google_analytics_id) && $this->moduleHandler->moduleExists('google_analytics')) {
      $google_analytics_config = $this->configFactory->get('google_analytics.settings');
      if ($google_analytics_config instanceof ImmutableConfig) {
        $google_analytics_id = $google_analytics_config->get('account');
      }
    }
    return $google_analytics_id;
  }

}
