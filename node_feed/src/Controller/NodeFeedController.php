<?php

namespace Drupal\node_feed\Controller;

use \Drupal\Core\Controller\ControllerBase;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use \Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Returns responses for Node feed module routes.
 */
class NodeFeedController extends ControllerBase {

  /**
   * Builds the page json page.
   */
  public function feed($site_key, $node_id) {
    // Get the site key from site settings.
    $site_config = \Drupal::config('system.site');
    $site_api_key = $site_config->get('siteapikey');

    // Load the node.
    $node = node_load($node_id);
    // Respond with result only for valid attempts.
    if ($node && $node->getType() == 'page' && $site_key == $site_api_key) {
      // Respond in json format.
      return new JsonResponse($node->toArray());
    }
    else {
      // Return access denied status for invalid attempts.
      throw new AccessDeniedHttpException();
    }
  }
}
