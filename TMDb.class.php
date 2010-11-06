<?php

/**
 * TMDb is a PHP wrapper for TMDb API which is mainly written 
 * to be used in Drupal modules, Also to be respectful 
 * to the coding standards of Drupal community.
 *
 * @version 0.1
 * @author Sepehr Lajevardi - me@sepehr.ws
 * 
 * @see http://api.themoviedb.org/2.1/
 *
 * @license GNU General Public License 3.0
 */
 
/**
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
 * TMDb API base class.
 *
 * Provides basic functionality to interact with http://api.themoviedb.org/2.1/.
 */
class TMDb {

  /**
   * @var Denotes XML format.
   *
   * @ingroup Constants
   */
  const XML = 'xml';
  
  /**
   * @var Denotes JSON format.
   *
   * @ingroup Constants
   */
  const JSON = 'json';
  
  /**
   * @var Denotes YAML format.
   *
   * @ingroup Constants
   */
  const YAML = 'yaml';
  
  /**
   * @var Denotes default API response language.
   *
   * @ingroup Constants
   */
  const LANG = 'en';
  
  /**
   * @var Denotes default API version.
   *
   * @ingroup Constants
   */
  const VERSION = 2.1;
  
  /**
   * @var Denotes default server address.
   *
   * @ingroup Constants
   */
  const SERVER = 'http://api.themoviedb.org/';
  
  /**
   * @var Denotes HTTP GET.
   *
   * @ingroup Constants
   */
  const GET = 'get';
  
  /**
   * @var Denotes HTTP POST.
   *
   * @ingroup Constants
   */
  const POST = 'post';
  
  /**
   * @var Denotes Auth type API methods.
   *
   * @ingroup Constants
   */
  const AUTH = 'Auth';
  
  /**
   * @var Denotes Media type API methods.
   *
   * @ingroup Constants
   */
  const MEDIA = 'Media';
  
  /**
   * @var Denotes Movie type API methods.
   *
   * @ingroup Constants
   */
  const MOVIE = 'Movie';
  
  /**
   * @var Denotes Person type API methods.
   *
   * @ingroup Constants
   */
  const PERSON = 'Person';
  
  /**
   * @var Denotes Genres type API methods.
   *
   * @ingroup Constants
   */
  const GENRES = 'Generes';
  
  /**
   * @var TMDb API key.
   *
   * ingroup Properties.
   */
  protected $key;
  
  /**
   * @var Default API response format.
   *
   * ingroup Properties.
   */
  protected $format;
  
  /**
   * @var API server address.
   *
   * ingroup Properties.
   */
  protected $server;
  
  /**
   * @var Preferred API version.
   *
   * ingroup Properties.
   */
  protected $version;
  
  /**
   * @var Default API response languagethroe.
   *
   * ingroup Properties.
   */
  protected $language;
  
  /**
   * Class constructor.
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
   * Sets API key.
   *
   * @param
   *   $key New API key to be set.
   */
  public function setKey($key) {
    $this->key = $key;
  }
  
  /**
   * Sets API server address.
   *
   * @param
   *   $key New API server to be set.
   */
  public function setServer($server) {
    $this->server = $server;
  }
  
  /**
   * Sets API version.
   *
   * @param
   *   $version New API version to be set.
   */
  public function setVersion($version) {
    $this->version = $version;
  }
  
  /**
   * Sets API response format.
   *
   * @param
   *   $format New API response format to be set.
   */
  public function setFormat($format) {
    $this->format = $format;
  }
  
  /**
   * Sets API response language.
   *
   * @param
   *   $language New API response language to be set.
   */
  public function setLanguage($language) {
    $this->language = $language;
  }
  
  /**
   * Gets API key.
   *
   * @return
   *   $key New API key to be set.
   */
  public function getKey() {
    return $this->key;
  }
  
  /**
   * Gets API server address.
   *
   * @return
   *   $key New API server to be set.
   */
  public function getServer() {
    return $this->server;
  }
  
  /**
   * Gets API version.
   *
   * @return
   *   $version New API version to be set.
   */
  public function getVersion() {
    return $this->version;
  }
  
  /**
   * Gets API response format.
   *
   * @return
   *   $format New API response format to be set.
   */
  public function getFormat() {
    return $this->format;
  }
  
  /**
   * Gets API response language.
   *
   * @return
   *   $language New API response language to be set.
   */
  public function getLanguage() {
    return $this->language;
  }
  
  /**
   * Builds API call URL for lazies to cheer!
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
	 * @throws TMDbException.
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
   * @throws TMDbException.
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
}

