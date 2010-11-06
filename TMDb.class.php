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
  public function __construct() {
    
  }
  
  /**
   * Set API key.
   */
  public function setKey() {

  }
  
  /**
   * Set API server address.
   */
  public function setServer() {

  }
  
  /**
   * Set API version.
   */
  public function setVersion() {

  }
  
  /**
   * Set API response format.
   */
  public function setFormat() {

  }
  
  /**
   * Set API response language.
   */
  public function setLanguage() {

  }
  
  /**
   * Get API key.
   */
  public function getKey() {

  }
  
  /**
   * Get API server address.
   */
  public function getServer() {

  }
  
  /**
   * Get API version.
   */
  public function getVersion() {

  }
  
  /**
   * Get API response format.
   */
  public function getFormat() {

  }
  
  /**
   * Get API response language.
   */
  public function getLanguage() {

  }
  
  /**
   * Builds API call URL for lazies to cheer!
   */
  protected function getBaseUrl() {

  }
  
  /**
   * Extracts and returns an API method's type.
   */
  protected function getMethodType() {

  }
}
