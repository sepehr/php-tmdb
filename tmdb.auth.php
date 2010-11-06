<?php

/**
 * TMDb is a PHP wrapper for TMDb API which is mainly written 
 * to be used in Drupal modules, Also to be respectful 
 * to the coding standards of Drupal community.
 *
 * @version 0.1
 *
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
 * TMDb Authentication API class.
 *
 * Provides higher level interaction for "Auth" type API methods.
 *
 * @see TMDb
 */
class TMDbAuth extends TMDb {
  
  /**
   * TMDb constructor who cries and calls his parent!
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
  public function __construct($key, $server = TMDbBase::SERVER, $version = TMDbBase::VERSION, $format = TMDbBase::JSON, $language = TMDbBase::LANG) {
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
   * @see http://api.themoviedb.org/2.1/methods/Auth.getToken
   */
  public function getAuthToken($format = NULL, $parse = TRUE) {
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
   *   Authentication session.
   * @see http://api.themoviedb.org/2.1/methods/Auth.getSession
   */
  public function getAuthSession($token, $format = NULL, $parse = TRUE) {
    $response = $this->call('Auth.getSession', $token, $format);
    return ($parse) ? $this->parse($response) : $response;
  }
}

