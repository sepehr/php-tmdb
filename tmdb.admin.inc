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
 * Validation callback for administration settings form.
 */
function tmdb_admin_api_settings_validate($form, &$form_state) {
  // Validate API version:
  if (!is_numeric($form_state['values']['tmdb_api_version'])) {
    form_set_error('tmdb_api_version', t('API version needs to be numeric.'));
  }

  // Validate API key format:
  if (strlen($form_state['values']['tmdb_api_key']) < 32 || is_numeric($form_state['values']['tmdb_api_key'])) {
    form_set_error('tmdb_api_key', t('API key needs to be an alphanumeric string with at least 32 characters.'));
  }

  // Validate API server:
  if (!valid_url($form_state['values']['tmdb_api_server'], TRUE)) {
    form_set_error('tmdb_api_server', t('API server needs to be a valid URL.'));
  }

  // Validates API format:
  if ($form_state['values']['tmdb_api_format'] == 'yaml' && !_tmdb_yaml_support()) {
    form_set_error('tmdb_api_format', t('There are no YAML parser available. Please choose JSON or XML instead.'));
  }

  // Fix API server trailing slash:
  if (substr(trim($form_state['values']['tmdb_api_server']), -1) != '/') {
    $form_state['values']['tmdb_api_server'] .= '/';
  }
}

/**
 * Page callback: TMDb admin API testing page.
 */
function tmdb_admin_api_testing() {
  // Check if the API key is set:
  if (variable_get('tmdb_api_key', FALSE)) {
    // TODO: Test API
    return 'API KEY SET, TEST API!';
  }
  // API key is not set:
  else {
    return t('To test the API you need to set your API key at !settings first.', array(
      '!settings' => l(t('settings page'), 'admin/settings/tmdb'),
    ));
  }
}

/**
 * Internal helper: Determines PHP YAML support.
 *
 * @return
 *   TRUE or FALSE.
 */
function _tmdb_yaml_support() {
  return (function_exists('yaml_parse') || function_exists('syck_load') || class_exists('Spyc'));
}
