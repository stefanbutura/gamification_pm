<?php

namespace Drupal\licenta_base\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\TitleBlockPluginInterface;
use Drupal\user\Entity\Role;
use Drupal\user\Entity\User;
use Drupal\user\UserInterface;

/**
 * Provides a block to display the user title.
 *
 * @Block(
 *   id = "licenta_base_user_title_block",
 *   admin_label = @Translation("User title"),
 * )
 */
class UserTitleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $request = \Drupal::request();
    $title = '';

    $user = \Drupal::routeMatch()->getParameter('user');
    if (!$user instanceof UserInterface) {
      return [];
    }

    /** @var User $user */
    $complete_title = $user->getAccountName();
    $complete_title .= ', ' . $user->field_primary_title->entity->getTitle();
    $complete_title .= ' ' . $user->field_secondary_title->entity->getTitle();

    $picture = $user->field_icon->entity->field_image;
    $user_class = $user->getRoles();
    $role = end($user_class);
    $role_label = Role::load($role)->label();

    return [
      '#theme' => 'licenta_base_user_title_block',
      '#title' => $complete_title,
      '#role' => $role_label,
      '#picture' => $picture,
    ];
  }

}

