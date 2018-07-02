<?php

namespace Drupal\licenta_base\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AddSpentTime extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'licenta_base_add_spent_time_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, $task_number = NULL) {
    $tasks = \Drupal::entityQuery('node')->condition('type', 'task')->condition('field_task_number', $task_number)->execute();
    if (!count($tasks)) {
      return;
    }

    $node = Node::load(reset($tasks));

    $form['task_id'] = array(
      '#type' => 'value',
      '#value' => $node->id(),
    );

    $form['spent_time'] = array(
      '#type' => 'number',
      '#title' => t('Spent time:'),
      '#required' => TRUE,
    );

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!is_numeric($form_state->getValue('spent_time'))) {
      $form_state->setErrorByName('spent_time', $this->t('Spent time value must be a number'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state, NodeInterface $node = NULL) {
    $task_id = $form_state->getValue('task_id');
    $user_id = \Drupal::currentUser()->id();

    $ts_node = Node::create([
      'type' => 'spent_time',
      'title' => \Drupal::currentUser()->getDisplayName() . date('Y-m-d'),
      'field_spent_time' => $form_state->getValue('spent_time'),
      'field_assignee' => ['target_id' => $user_id],
      'field_task' => ['target_id' => $task_id],
    ]);
    $ts_node->save();

//    $task = Node::load($task_id);
//    $task->field_spent_time->value += $form_state->getValue('spent_time');
//    $task->save();

    drupal_set_message('Successfully added spent time');
    $url = Url::fromRoute('entity.node.canonical', ['node' => $task_id]);
    $form_state->setRedirectUrl($url);
  }
}
