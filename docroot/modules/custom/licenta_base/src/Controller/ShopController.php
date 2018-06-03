<?php

namespace Drupal\licenta_base\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\licenta_base\LicentaHelper;
use Drupal\node\NodeInterface;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * An example controller.
 */
class ShopController extends ControllerBase {

  public function buyItem(NodeInterface $node) {
    $route_name = 'view.shop.page_1';
    $url = Url::fromRoute($route_name)->toString();
    if (!$node instanceof NodeInterface || $node->bundle() != 'icon') {
      drupal_set_message('Item no longer exists', 'error');
      return new RedirectResponse($url);
    }

    $current_user = User::load(\Drupal::currentUser()->id());
    $current_user_gold = $current_user->field_gold->value;

    if (!LicentaHelper::isAffordable($node)) {
      drupal_set_message('Not enough gold to buy this item', 'error');
      return new RedirectResponse($url);
    }

    if (LicentaHelper::isAlreadyOwned($node)) {
      drupal_set_message('Item already owned', 'error');
      return new RedirectResponse($url);
    }

    $current_user->field_gold->value -= $node->field_price->value;
    $current_user->field_rewards[] = $node;
    $current_user->save();
    drupal_set_message('Item was bought successfully');
    return new RedirectResponse($url);
  }

}
