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
 * TMDb Movie API class.
 *
 * Provides higher level interaction for "Movie" type API methods.
 *
 * @see TMDb class.
 */
class TMDbMovie extends TMDb {
  
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
    $response = $this->call('Movie.addRating', $params, $format, $language, TMDbBase::POST);
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
}

