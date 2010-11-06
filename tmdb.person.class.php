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
 * TMDb Person API class.
 *
 * Provides higher level interaction for "Person" type API methods.
 *
 * @see TMDb class.
 */
class TMDbPerson extends TMDb {
  
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
  public function getPersonInfo($pid, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Person.getInfo', $pid, $format, $language);
    return ($parse) ? $this->parse($response) : $response;
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
  public function getLatestPerson($format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Person.getLatest', NULL, $format, $language);
    return ($parse) ? $this->parse($response) : $response;
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
   *    Last modified time along with the current version number.
   *
   * @see http://api.themoviedb.org/2.1/methods/Person.getVersion
   */
  public function getPersonVersion($pids, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Person.getVersion', $pids, $format, $language);
    return ($parse) ? $this->parse($response) : $response;
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
  public function searchPerson($name, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Person.search', $name, $format, $language);
    return ($parse) ? $this->parse($response) : $response;
  }
}

