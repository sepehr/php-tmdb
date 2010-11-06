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
 * TMDb API base class.
 * Provides basic functionality to interact with http://api.themoviedb.org/2.1/.
 */
class TMDb {
  // TODO: Add properties docs.
  
  // API call default params.
  const XML = 'xml';
  const JSON = 'json';
  const YAML = 'yaml';
  const LANG = 'en';
  const VERSION = 2.1;
  const SERVER = 'http://api.themoviedb.org/';
  
  // API call HTTP methods.
  const GET = 'get';
  const POST = 'post';
  
  // API method types.
  const AUTH = 'Auth';
  const MEDIA = 'Media';
  const MOVIE = 'Movie';
  const PERSON = 'Person';
  const GENRES = 'Generes';
  
  // Props.
  protected $key;
  protected $format;
  protected $server;
  protected $version;
  protected $language;
  
  /**
   * Class constructor.
   */
  public function __construct($key, $server = TMDb::SERVER, $version = TMDb::VERSION, $format = TMDb::JSON, $language = TMDb::LANG) {
    $this->setKey($key);
    $this->setServer($server);
    $this->setVersion($version);
    $this->setFormat($format);
    $this->setLanguage($language);
  }
  
  /**
   * Set API key.
   *
   * @param
   *   $key New API key to be set.
   */
  public function setKey($key) {
    $this->key = $key;
  }
  
  /**
   * Set API server address.
   *
   * @param
   *   $key New API server to be set.
   */
  public function setServer($server) {
    $this->server = $server;
  }
  
  /**
   * Set API version.
   *
   * @param
   *   $version New API version to be set.
   */
  public function setVersion($version) {
    $this->version = $version;
  }
  
  /**
   * Set API response format.
   *
   * @param
   *   $format New API response format to be set.
   */
  public function setFormat($format) {
    $this->format = $format;
  }
  
  /**
   * Set API response language.
   *
   * @param
   *   $language New API response language to be set.
   */
  public function setLanguage($language) {
    $this->language = $language;
  }
  
  /**
   * Get API key.
   *
   * @return
   *   $key New API key to be set.
   */
  public function getKey() {
    return $this->key;
  }
  
  /**
   * Get API server address.
   *
   * @return
   *   $key New API server to be set.
   */
  public function getServer() {
    return $this->server;
  }
  
  /**
   * Get API version.
   *
   * @return
   *   $version New API version to be set.
   */
  public function getVersion() {
    return $this->version;
  }
  
  /**
   * Get API response format.
   *
   * @return
   *   $format New API response format to be set.
   */
  public function getFormat() {
    return $this->format;
  }
  
  /**
   * Get API response language.
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
   */
  protected function getMethodType() {

  }
}
