<?php

namespace Drupal\licenta_base;

use Drupal\node\NodeInterface;
use Drupal\user\Entity\User;

class LicentaHelper {
  static $STATUS_APPROVED = 7;

  static function getLevelFromXp($xp) {
    $level = 1;
    for ($i = 100; $i < $xp; $i += 50) {
      $xp -= $i;
      $level++;
    }
    return $level;
  }

  static function isAlreadyOwned(NodeInterface $node) {
    $current_user = User::load(\Drupal::currentUser()->id());
    $current_user_rewards = $current_user->field_rewards->getValue();
    foreach ($current_user_rewards as $current_user_reward) {
      if ($current_user_reward['target_id'] == $node->id()) {
        return TRUE;
      }
    }
    return FALSE;
  }

  static function isAffordable(NodeInterface $node) {
    $current_user = User::load(\Drupal::currentUser()->id());
    if (empty($node->field_price)) {
      return FALSE;
    }
    if ($current_user->field_gold->value < $node->field_price->value) {
      return FALSE;
    }
    return TRUE;
  }

}
