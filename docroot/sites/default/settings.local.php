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
  'host' => 'localhost',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);

$settings['hash_salt'] = 'c0659f054ad4fc7a748eff255cbbf603e0369bcec23e62fd045dd6a72e523e88';
ini_set('xdebug.max_nesting_level', 300);

$config['swiftmailer.transport'] = array(
  'transport' => 'smtp',
  'smtp_host' => 'secure.emailsrvr.com',
  'smtp_port' => '465',
  'smtp_encryption' => 'ssl',
  'smtp_username' => 'stefan.butura@eaudeweb.ro',
  'smtp_password' => '',

  'sendmail_path' => '/usr/sbin/sendmail',
  'sendmail_mode' => 'bs',
  'spool_directory' => '',
);

$settings['trusted_certificates_folder'] = '/sites/default/files/xd';
