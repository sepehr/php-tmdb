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
 * TMDb API class.
 *
 * Provides higher level interaction with http://api.themoviedb.org/2.1/.
 *
 * @see TMDb class.
 */
class TMDbAPI extends TMDb {
  
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
  public function __construct($key, $server = TMDb::SERVER, $version = TMDb::VERSION, $format = TMDb::JSON, $language = TMDb::LANG) {
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
    $response = $this->call('Media.addID', $params, $format, $language, TMDb::POST);
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
  public function addMovieRating($params, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.addRating', $params, $format, $language, TMDb::POST);
    return ($parse) ? $this->parse($response) : $response;
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
  public function browseMovie($order_by, $order, $params = array(), $format = NULL, $language = NULL, $parse = TRUE) {
    $params['order'] = $order;
    $params['order_by'] = $order_by;
    $response = $this->call('Movie.browse', $params, $format, $language);
    
    return ($parse) ? $this->parse($response) : $response;
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
   *   Authentication session.
   *
   * @see http://api.themoviedb.org/2.1/methods/Movie.getImages
   */
  public function getMovieImages($mid, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.getImages', $mid, $format, $language);
    return ($parse) ? $this->parse($response) : $response;
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
   *   Authentication session.
   *
   * @see http://api.themoviedb.org/2.1/methods/Movie.getInfo
   */
  public function getMovieInfo($tmid, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.getInfo', $tmid, $format, $language);
    return ($parse) ? $this->parse($response) : $response;
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
  public function getLatestMovie($format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.getLatest', NULL, $format, $language);
    return ($parse) ? $this->parse($response) : $response;
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
  public function getMovieTranslations($mid, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.getTranslations', $mid, $format, $language);
    return ($parse) ? $this->parse($response) : $response;
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
   *   Last modified time along with the current version number.
   *
   * @see http://api.themoviedb.org/2.1/methods/Movie.getVersion
   */
  public function getMovieVersion($mids, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.getVersion', $mids, $format, $language);
    return ($parse) ? $this->parse($response) : $response;
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
  public function imdbMovieLookup($imid, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.imdbLookup', $imid, $format, $language);
    return ($parse) ? $this->parse($response) : $response;
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
  public function searchMovie($title, $format = NULL, $language = NULL, $parse = TRUE) {
    $response = $this->call('Movie.search', $title, $format, $language);
    return ($parse) ? $this->parse($response) : $response;
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

