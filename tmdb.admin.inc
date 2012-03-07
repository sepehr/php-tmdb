<?php

/**
 * @file tmdb.admin.inc
 * Contains administration form and page callbacks for TMDb module.
 */

/**
 * Form callback: TMDb admin settings form.
 *
 * @return
 *   Rendered form.
 *
 * @ingroup forms
 * @see system_settings_form()
 */
function tmdb_admin_api_settings() {
  $form = array();
  // Wrapper fieldset:
  $form['tmdb_config'] = array(
    '#type' => 'fieldset',
    '#title' => t('API Settings'),
  );
  // API key:
  $form['tmdb_config']['tmdb_api_key'] = array(
    '#type' => 'textfield',
    '#title' => t('API Key'),
    '#description' => t('You need a TMDb account to be able to use the API. Grab your API key at http://themoviedb.org/account/[USERNAME] under the API tab.'),
    '#default_value' => variable_get('tmdb_api_key', ''),
    '#required' => TRUE,
  );
  // API server:
  $form['tmdb_config']['tmdb_api_server'] = array(
    '#type' => 'textfield',
    '#title' => t('API Server'),
    '#description' => t('API server address with trailing slash. Do not change the default value unless there is an API server change announced by TMDb.'),
    '#default_value' => variable_get('tmdb_api_server', 'http://api.themoviedb.org/'),
    '#required' => TRUE,
  );
  // API version:
  $form['tmdb_config']['tmdb_api_version'] = array(
    '#type' => 'textfield',
    '#title' => t('API Version'),
    '#description' => t('The API version. Change this to the API version you wish to interact with.'),
    '#default_value' => variable_get('tmdb_api_version', '2.1'),
    '#required' => TRUE,
  );
  // API format:
  $form['tmdb_config']['tmdb_api_format'] = array(
    '#type' => 'radios',
    '#title' => t('API Response Format'),
    '#description' => t('Default response format for API calls. JSON is preferred.'),
    '#default_value' => variable_get('tmdb_api_format', 'json'),
    '#required' => TRUE,
    '#options' => array(
      'xml'  => t('XML'),
      'json' => t('JSON'),
      'yaml' => t('YAML <span class="tmdb-formats-desc">- !link</span>', array(
        '!link' => l(t('Requires a PHP YAML parser.'), 'http://www.php.net/manual/en/yaml.setup.php'))
      ),
    ),
  );

  return system_settings_form($form);
}

/**
 * Page callback: TMDb admin API testing page.
 */
function tmdb_admin_api_testing() {
}
