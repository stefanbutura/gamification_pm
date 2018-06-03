<?php

namespace Drupal\licenta_base\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\TitleBlockPluginInterface;
use Drupal\licenta_base\LicentaHelper;
use Drupal\user\Entity\Role;
use Drupal\user\Entity\User;
use Drupal\user\UserInterface;

/**
 * Provides a block to display the user title.
 *
 * @Block(
 *   id = "licenta_base_user_stats_block",
 *   admin_label = @Translation("User stats"),
 * )
 */
class UserStatsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $request = \Drupal::request();

    $user = \Drupal::routeMatch()->getParameter('user');
    if (!$user instanceof UserInterface) {
      return [];
    }

    $level = $user->field_level->value;
    $tasks = \Drupal::entityQuery('node')
      ->condition('type', 'task')
      ->condition('status', 1)
      ->condition('field_workflow_status', LicentaHelper::$STATUS_APPROVED)
      ->condition('field_assignee.entity.uid', $user->id())
      ->execute();

    $task_count = count($tasks);

    $total_time = 0;
    $spent_time = \Drupal::entityQuery('node')
      ->condition('type', 'spent_time')
      ->condition('field_assignee.entity.uid', $user->id())
      ->execute();

    foreach ($spent_time as $node) {
      $total_time += $node->field_spent_time->value;
    }

    return [
      '#theme' => 'licenta_base_user_stats_block',
      '#spent_time' => $total_time,
      '#task_count' => $task_count,
    ];
  }

}

