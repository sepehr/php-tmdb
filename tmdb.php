<?php

/**
 * TMDbPHP - PHP API Wrapper for TMDb API
 *
 * TMDbPHP is a PHP wrapper for TMDb API (http://api.themoviedb.org)
 * which is mainly written to be used in Drupal modules, not to be
 * considered as an external library also to be respectful to the
 * coding standards of Drupal community. You may find more info and
 * docs in the project homepage at http://github.com/sepehr/tmdbphp.
 *
 * @version 1.x-dev
 *
 * @author Sepehr Lajevardi <me@sepehr.ws>
 * @copyright Copyright (c) 2011 - Sepehr Lajevardi
 * @license GNU General Public License 3.0 - http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * TMDb base class which contains the functionalities required to interact with API.
 *
 * ADD CLASS DESCRIPTION HERE.
 *
 * Example usage:
 * ADD EXAMPLE USAGE CODE HERE.
 *
 * @see http://api.themoviedb.org
 * @todo Review the code, it's for about a year ago, blah bla.
 */
class TMDb {
  // API call default params:
  const XML     = 'xml';
  const JSON    = 'json';
  const YAML    = 'yaml';
  const LANG    = 'en';
  const VERSION = 2.1;
  const SERVER  = 'http://api.themoviedb.org/';
  // API call HTTP methods:
  const GET  = 'get';
  const POST = 'post';
  // API method types:
  const AUTH   = 'Auth';
  const MEDIA  = 'Media';
  const MOVIE  = 'Movie';
  const PERSON = 'Person';
  const GENRES = 'Generes';

  /**
   * API key string.
   *
   * @var string
   */
  protected $key;
  /**
   * API response preferred format.
   *
   * @var string
   */
  protected $format;
  /**
   * API server endpoint URI.
   *
   * @var string
   */
  protected $server;
  /**
   * API version.
   *
   * @var string
   */
  protected $version;
  /**
   * API response language.
   *
   * @var string
   */
  protected $language;

  /**
   * TMDb class constructor.
   *
   * @param $key
   *   API key.
   * @param $server
   *   API server address.
   * @param $version
   *   API version.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   */
  public function __construct($key, $server = TMDb::SERVER, $version = TMDb::VERSION, $format = TMDb::JSON, $language = TMDb::LANG) {
    $this->setKey($key);
    $this->setServer($server);
    $this->setVersion($version);
    $this->setFormat($format);
    $this->setLanguage($language);
  }

  /**
   * Setter for API key.
   *
   * @param $key
   *   New API key to be set.
   */
  public function setKey($key) {
    $this->key = $key;
  }

  /**
   * Setter for API server endpoint.
   *
   * @param $server
   *   New API server to be set.
   */
  public function setServer($server) {
    $this->server = $server;
  }

  /**
   * Setter for API version.
   *
   * @param $version
   *   New API version to be set.
   */
  public function setVersion($version) {
    $this->version = $version;
  }

  /**
   * Setter for API response format.
   *
   * @param $format
   *   New API response format to be set.
   */
  public function setFormat($format) {
    $this->format = $format;
  }

  /**
   * Setter for API response language.
   *
   * @param $language
   *   New API response language to be set.
   */
  public function setLanguage($language) {
    $this->language = $language;
  }

  /**
   * Getter for API key.
   *
   * @return
   *   Current API key.
   */
  public function getKey() {
    return $this->key;
  }

  /**
   * Getter for API server address.
   *
   * @return
   *   Current API server endpoint.
   */
  public function getServer() {
    return $this->server;
  }

  /**
   * Getter for API version.
   *
   * @return
   *   Current API version to be set.
   */
  public function getVersion() {
    return $this->version;
  }

  /**
   * Getter for API response format.
   *
   * @return
   *   Current API response format.
   */
  public function getFormat() {
    return $this->format;
  }

  /**
   * Getter for API response language.
   *
   * @return
   *   Current API response language.
   */
  public function getLanguage() {
    return $this->language;
  }

  /**
   * Builds API call URL while taking care of trailing slashes.
   *
   * @return
   *   API call URI.
   */
  protected function getBaseUrl() {
    $server = $this->getServer();
    if (substr(trim($server), -1) != '/') {
      $server .= '/';
    }

    return $server . $this->getVersion() . '/';
  }

  /**
   * Extracts and returns an API method's type.
   *
   * @param
   *   $method The name of the API method.
   *
   * @return
   *   The API method's type.
   *
   * @see http://api.themoviedb.org/2.1/
   */
  protected function getMethodType($method) {
    return substr($method, 0, strpos($method, '.'));
  }

  /**
   * Builds API call GET URL for a specific method.
   *
   * @param $method
   *   API call method name.
   * @param $params
   *   API method parameteres to be passed.
   *
   * @return
   *   Built API call URL.
   *
   * @see buildBaseUrl()
   * @see http://api.themoviedb.org/2.1/
   */
  protected function buildCallUrl($method, $params, $format, $language) {
    $parts = array($method);
    if (!is_null($language))
      $parts[] = $language;
    $parts[] = $format;
    $parts[] = $this->getKey();

    $call_url = $this->getBaseUrl() . implode('/', $parts);
    if (!is_null($params)) {
      switch ($params[0]) {
        case '?':
          $call_url .= $params;
          break;

        default:
          $call_url .= '/' . $params;
      }
    }
    return $call_url;
  }

  /**
   * Fetches a remote file using either cURL functions or file_get_contents().
   *
   * @param $url
   *   File URL to be fetched.
   * @param $http_method
   *   API call HTTP method.
   * @param $post_params
   *   Parameters to be sent if the $http_method is POST.
   * @param $use_curl
   *   To use cURL or not.
   *
   * @return
   *   Fetched file contents.
   */
  protected function fetch($url, $http_method = TMDb::GET, $post_params = NULL, $use_curl = TRUE) {
    if (!extension_loaded('curl') || !$use_curl) {
      return file_get_contents($url);
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    if ($http_method == TMDb::POST) {
      curl_setopt($curl, CURLOPT_POST, TRUE);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post_params);
    }

    $response = curl_exec($curl);
    curl_close($curl);
    return (string) $response;
  }

  /**
   * Call a TMDb API method.
   *
   * @param $method
   *   API method name to be included in the API Call URL.
   * @param $params
   *   Parameters to be included in the API Call URL. Either an array or a string.
   * @param $format
   *   Specific API response format for $method call.
   * @param $http_method
   *   The HTTP method to be used for the call.
   *   If set to POST, the $params parameter "should" be an array.
   * @param $language
   *   Specific API response language for $method call.
   *
   * @return
   *   API response in $format.
   */
  public function call($method, $params = NULL, $format = NULL, $language = NULL, $http_method = TMDb::GET) {
    $call_url = $response = NULL;
    $format = (is_null($format)) ? $this->getFormat() : $format;
    $language = (is_null($language)) ? $this->getLanguage() : $language;

    switch (strtolower($http_method)) {
      case TMDb::GET:
        // Check parameters.
        if (!is_null($params)) {
          $params = (is_array($params)) ? '?' . http_build_query($params) : urlencode($params);
        }

        // Check language and set the API call URL.
        $language = ($this->getMethodType($method) == TMDb::AUTH) ? NULL : $this->getLanguage();
        $call_url = $this->buildCallUrl($method, $params, $format, $language);
        $response = $this->fetch($call_url);
        break;

      case TMDb::POST:
        if (!is_array($params)) {
          throw new TMDbException('The $params parameter passed to call() method should be an array when using HTTP POST method.');
        }
        $params['type'] = $format;
        $params['api_key'] = $this->getKey();
        $call_url = $this->getBaseUrl() . $method;
        $response = $this->fetch($call_url, TMDb::POST, $params);
        break;
    }

    return $response;
  }

  /**
   * Parses a YAML formatted $response.
   * Checks for availability of PHP YAML parsers.
   *
   * @param $yaml_response
   *   YAML formatted response to be parsed.
   *
   * @throws TMDbException
   *
   * @return
   *   Parsed YAML response.
   */
  protected function parseYaml($yaml_response) {
    if (function_exists('yaml_parse')) {
      return yaml_parse($yaml_response);
    }

    if (function_exists('syck_load')) {
      return syck_load($yaml_response);
    }

    if (class_exists('Spyc')) {
      return Spyc::YAMLLoad($yaml_response);
    }

    throw new TMDbException('Could not found a PHP YAML parser.');
  }

  /**
   * Parses API call response.
   *
   * @param $response
   *   API call response.
   * @param $format
   *   API call response format.
   *
   * @returns
   *   An associative array objects decoded from $response.
   */
  protected function parse($response, $format = NULL) {
    if (empty($response) || is_null($response) || !$response) {
      return NULL;
    }

    $format = (is_null($format)) ? $this->getFormat() : $format;

    switch (strtolower($format)) {
      case TMDb::JSON:
        $parsed = json_decode($response, TRUE);
        break;

      case TMDb::XML:
        $parsed =  simplexml_load_string($response);
        break;

      case TMDb::YAML:
        $parsed = $this->parseYaml($response);
        break;
    }

    return $parsed;
  }
} // TMDb class.

/**
 * TMDb main API wrapper class extending the base one (TMDb).
 *
 * ADD CLASS DESCRIPTION HERE.
 *
 * Example usage:
 * ADD EXAMPLE USAGE CODE HERE.
 *
 * @see http://api.themoviedb.org
 * @todo Review the code, it's for about a year ago, blah bla.
 */
class TMDbAPI extends TMDb {

  /**
   * TMDbAPI constructor.
   *
   * @param $key
   *   API key.
   * @param $server
   *   API server address.
   * @param $version
   *   API version.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   */
  public function __construct($key, $server = TMDb::SERVER, $version = TMDb::VERSION, $format = TMDb::JSON, $language = TMDb::LANG) {
    parent::__construct($key, $server, $version, $format, $language);
  }


} // TMDbAPI class.

/**
 * The Exception class for TMDb specific exceptions.
 *
 * Defining to be compatible with Drupal coding
 * standards. We might extend this class per need.
 */
class TMDbException extends Exception{}
