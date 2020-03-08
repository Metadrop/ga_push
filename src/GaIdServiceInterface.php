<?php

namespace Drupal\ga_push;

/**
 * Interface GaIdServiceInterface.
 */
interface GaIdServiceInterface {

  /**
   * Get the Google Analytics ID.
   *
   * Either from google_analytics module service
   * or from our own service.
   */
  public function getAnalyticsId();

}
