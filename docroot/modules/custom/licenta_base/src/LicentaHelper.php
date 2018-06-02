<?php

namespace Drupal\licenta_base;

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

}
