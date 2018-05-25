<?php
$settings['twig_debug'] = FALSE;
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';
$settings['testing_url'] = 'http://licenta.local';
$settings['environment'] = 'dev';
$settings['file_private_path'] = 'sites/default/private';
$config['system.performance']['css']['preprocess'] = FALSE;
$config['system.performance']['js']['preprocess'] = FALSE;

$databases['default']['default'] = array(
  'database' => 'licenta',
  'username' => 'root',
  'password' => 'root',
  'prefix' => '',
  'host' => 'db',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);

$settings['hash_salt'] = 'c0659f054ad4fc7a748eff255cbbf603e0369bcec23e62fd045dd6a72e523e88';
ini_set('xdebug.max_nesting_level', 300);
