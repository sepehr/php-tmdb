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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * TMDbCore core class, contains underlying methods of TMDbAPI class.
 *
 * TMDbCore class is consists of required helpers and utilities which
 * is needed for every class that implements TMDb API in PHP.
 *
 * Example usage:
 * <code>
 *   function foo() {
 *     $tmdbcore = new TMDbCore('TMDB_API_KEY_HERE');
 *     $response = $tmdbcore->call('Movie.browse', $params, $format, $language);
 *     return $tmdbcore->parse($response);
 *   }
 * </code>
 *
 * <code>
 *   class TMDbFooWrapper extends TMDbCore {
 *     public function __construct($key, $server, $version, $format, $language) {
 *       parent::__construct($key, $server, $version, $format, $language);
 *     }
 *
 *    public function fooBarMovieBrowse($params, $format = TMDbCore::JSON, $language = TMDbCore::LANG) {
 *      if (is_ok_bla($params)) {
 *        return $this->parse($this->call('Movie.browse'), $params, $format, $language);
 *      }
 *    }
 *   } // TMDbFooWrapper class
 * </code>
 *
 * @see http://api.themoviedb.org
 * @todo
 *   - Review the code, it's for about a year ago, blah bla.
 *   - TMDb's "Auth.getToken" and "Auth.getSession" has been
 *     eventually deprecated. We need to drop these methods and
 *     implement the v3 authentication process documented at:
 *     http://help.themoviedb.org/kb/api/user-authentication
 */
class TMDbCore {
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
  public function __construct($key, $server = TMDbCore::SERVER, $version = TMDbCore::VERSION, $format = TMDbCore::JSON, $language = TMDbCore::LANG) {
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
  protected function fetch($url, $http_method = TMDbCore::GET, $post_params = NULL, $use_curl = TRUE) {
    if (!extension_loaded('curl') || !$use_curl) {
      return file_get_contents($url);
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    if ($http_method == TMDbCore::POST) {
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
   * @throws TMDbException
   *
   * @return
   *   API response in $format.
   */
  public function call($method, $params = NULL, $format = NULL, $language = NULL, $http_method = TMDbCore::GET) {
    $call_url = $response = NULL;
    $format = (is_null($format)) ? $this->getFormat() : $format;
    $language = (is_null($language)) ? $this->getLanguage() : $language;

    switch (strtolower($http_method)) {
      case TMDbCore::GET:
        // Check parameters.
        if (!is_null($params)) {
          $params = (is_array($params)) ? '?' . http_build_query($params) : urlencode($params);
        }

        // Check language and set the API call URL.
        $language = ($this->getMethodType($method) == TMDbCore::AUTH) ? NULL : $this->getLanguage();
        $call_url = $this->buildCallUrl($method, $params, $format, $language);
        $response = $this->fetch($call_url);
        break;

      case TMDbCore::POST:
        if (!is_array($params)) {
          throw new TMDbException('The $params parameter passed to call() method should be an array when using HTTP POST method.');
        }
        $params['type'] = $format;
        $params['api_key'] = $this->getKey();
        $call_url = $this->getBaseUrl() . $method;
        $response = $this->fetch($call_url, TMDbCore::POST, $params);
        break;
    }

    return $response;
  }

  /**
   * Parses API call response.
   *
   * @param $response
   *   API call response.
   * @param $format
   *   API call response format.
   *
   * @return
   *   An associative array of objects decoded from $response.
   */
  protected function parse($response, $format = NULL) {
    if (empty($response) || is_null($response) || !$response) {
      return NULL;
    }

    $format = (is_null($format)) ? $this->getFormat() : $format;

    switch (strtolower($format)) {
      case TMDbCore::JSON:
        $parsed = json_decode($response, TRUE);
        break;

      case TMDbCore::XML:
        $parsed =  simplexml_load_string($response);
        break;

      case TMDbCore::YAML:
        $parsed = $this->parseYaml($response);
        break;
    }

    return $parsed;
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

} // TMDbCore class.


/**
 * TMDb main API wrapper class extending the base one (TMDbCore).
 *
 * TMDbAPI method names are identical to TMDb remote method names,
 * they're just camelCased. For example if you want to call TMDb's
 * "Auth.getToken" remote method, you should use "authGetToken"
 * local method.
 *
 * Example usage:
 * <code>
 *   $TMDb = new TMDbAPI('TMDB_API_KEY_HERE');
 *   $images = $TMDb->movieGetImages($tmid);
 * </code>
 *
 * @see http://api.themoviedb.org
 * @todo Review the code, it's for about a year ago, blah bla.
 */
class TMDbAPI extends TMDbCore {

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
  public function __construct($key, $server, $version, $format, $language) {
    parent::__construct($key, $server, $version, $format, $language);
  }

  /**
   * Calls API's Auth.getToken method.
   *
   * @param $format
   *   API call response format.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Authentication token.
   *
   * @see http://api.themoviedb.org/2.1/methods/Auth.getToken
   * @see http://help.themoviedb.org/kb/api/user-authentication
   *
   * @todo DROP.
   */
  public function authGetToken($format = NULL, $parse = TRUE) {
    $response = $this->call('Auth.getToken', NULL, $format);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Auth.getSession method.
   *
   * @param $token
   *   Authentication token.
   * @param $format
   *   API call response format.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Authentication session
   *
   * @see http://api.themoviedb.org/2.1/methods/Auth.getSession
   * @see http://help.themoviedb.org/kb/api/user-authentication
   *
   * @todo DROP.
   */
  public function authGetSession($token, $format = NULL, $parse = TRUE) {
    $response = $this->call('Auth.getSession', $token, $format);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Media.addID method.
   *
   * @param $params
   *   Associative array to be used in POST API call.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Status code.
   *
   * @see http://api.themoviedb.org/2.1/methods/Media.addID
   */
  public function mediaAddID($params, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Media.addID', $params, $format, $language, TMDbCore::POST);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Media.getInfo method.
   *
   * @param $hash
   *   The computed hash of the file you are doing a lookup for.
   * @param $bytesize
   *   The bytesize of the file you are doing a lookup for.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Media info.
   *
   * @see http://api.themoviedb.org/2.1/methods/Media.getInfo
   */
  public function mediaGetInfo($hash, $bytesize, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Media.getInfo', $hash . '/' . $bytesize, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Movie.addRating method.
   *
   * @param $hash
   *   The computed hash of the file you are doing a lookup for.
   * @param $bytesize
   *   The bytesize of the file you are doing a lookup for.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Status code.
   * @see http://api.themoviedb.org/2.1/methods/Movie.addRating
   */
  public function movieAddRating($params, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.addRating', $params, $format, $language, TMDbCore::POST);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Movie.browse method.
   *
   * @param $order_by
   *   Order by rating, release or title.
   * @param $order
   *   Ascending(asc) order or descending(desc).
   * @param $params
   *   An associative array of optional parameters:
   *   - per_page
   *   - page
   *   - query
   *   - min_votes
   *   - rating_min
   *   - rating_max
   *   - genres
   *   - genres_selector
   *   - release_min
   *   - release_max
   *   - year
   *   - certifications
   *   - companies
   *   - countries
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Bunch of movies.
   *
   * @see http://api.themoviedb.org/2.1/methods/Movie.browse
   */
  public function movieBrowse($order_by, $order, $params = array(), $format = NULL, $language = NULL, $parse = TRUE) {
    $params['order'] = $order;
    $params['order_by'] = $order_by;
    $response = $this->call('Movie.browse', $params, $format, $language);

    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Movie.getImages method.
   *
   * @param $mid
   *   TMDb ID or IMDB ID (starting with tt) of the movie to search for.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Movie images.
   *
   * @see http://api.themoviedb.org/2.1/methods/Movie.getImages
   */
  public function movieGetImages($mid, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.getImages', $mid, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Movie.getInfo method.
   *
   * @param $tmid
   *   TMDb ID of the movie to get its info.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Movie info.
   *
   * @see http://api.themoviedb.org/2.1/methods/Movie.getInfo
   */
  public function movieGetInfo($tmid, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.getInfo', $tmid, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Movie.getLatest method.
   *
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Latest movie added to TMDb.
   *
   * @see http://api.themoviedb.org/2.1/methods/Movie.getLatest
   */
  public function movieGetLatest($format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.getLatest', NULL, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Movie.getTranslations method.
   *
   * @param $mid
   *   TMDb ID or IMDB ID (starting with tt) of the movie to get translations for.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Movie translations.
   *
   * @see http://api.themoviedb.org/2.1/methods/Movie.getTranslations
   */
  public function movieGetTranslations($mid, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.getTranslations', $mid, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Movie.getVersion method.
   *
   * @param $mids
   *   A comma separated TMDb or IMDb IDs of the movies to lookup for.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Last modified time alongside the current version number.
   *
   * @see http://api.themoviedb.org/2.1/methods/Movie.getVersion
   */
  public function movieGetVersion($mids, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.getVersion', $mids, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Movie.imdbLookup method.
   *
   * @param $imid
   *   The IMDb ID of the movie to lookup for.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Movie info.
   *
   * @see http://api.themoviedb.org/2.1/methods/Movie.imdbLookup
   */
  public function movieImdbLookup($imid, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.imdbLookup', $imid, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Movie.search method.
   *
   * @param $title
   *   The title of the movie you are searching for.
   *   You can add the year of the movie to your search string to narrow your results.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   A list of resulted movies.
   *
   * @see http://api.themoviedb.org/2.1/methods/Movie.search
   */
  public function movieSearch($title, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.search', $title, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Person.getInfo method.
   *
   * @param $pid
   *   The ID of the TMDb person to get info for.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *   Full filmography, known movies, images and things
   *   like birthplace for a specific person in the TMDb.
   *
   * @see http://api.themoviedb.org/2.1/methods/Person.getInfo
   */
  public function personGetInfo($pid, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Person.getInfo', $pid, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Person.getLatest method.
   *
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *    The ID of the last person created in the TMDb.
   *
   * @see http://api.themoviedb.org/2.1/methods/Person.getLatest
   */
  public function personGetLatest($format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Person.getLatest', NULL, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Person.getVersion method.
   *
   * @param $pids
   *   A comma separated TMDb IDs of the persons to lookup for.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *    Last modified time alongside the current version number.
   *
   * @see http://api.themoviedb.org/2.1/methods/Person.getVersion
   */
  public function personGetVersion($pids, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Person.getVersion', $pids, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Person.search method.
   *
   * @param $name
   *   The name of the person to search for.
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *    A list of resulted persons.
   *
   * @see http://api.themoviedb.org/2.1/methods/Person.search
   */
  public function personSearch($name, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Person.search', $name, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

  /**
   * Calls API's Genres.getList method.
   *
   * @param $format
   *   API call response format.
   * @param $language
   *   API call response language.
   * @param $parse
   *   To parse response or not.
   *
   * @return
   *    A list of valid genres within TMDb.
   *
   * @see http://api.themoviedb.org/2.1/methods/Genres.getList
   */
  public function genresGetList($format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Genres.getList', NULL, $format, $language);
    return ($parse) ? $this->parse($response, $format) : $response;
  }

} // TMDbAPI class.

/**
 * The Exception class for TMDb specific exceptions.
 *
 * Defining to be compatible with Drupal coding
 * standards. We might extend this class per need.
 */
class TMDbException extends Exception {}
