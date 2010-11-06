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
 * TMDb Media API class.
 *
 * Provides higher level interaction for "Media" type API methods.
 *
 * @see TMDb class.
 */
class TMDbMedia extends TMDb {
  
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
   * @see http://api.themoviedb.org/2.1/methods/Media.addID
   */
  public function addMediaId($params, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Media.addID', $params, $format, $language, TMDbBase::POST);
    return ($parse) ? $this->parse($response) : $response;
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
   * @see http://api.themoviedb.org/2.1/methods/Media.getInfo
   */
  public function getMediaInfo($hash, $bytesize, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Media.getInfo', $hash . '/' . $bytesize, $format, $language);
    return ($parse) ? $this->parse($response) : $response;
  }
}

