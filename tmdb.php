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
 * TMDb class is the API wrapper, you know!
 *
 * ADD CLASS DESCRIPTION HERE.
 *
 * Example usage:
 * ADD EXAMPLE USAGE CODE HERE.
 *
 * @see http://api.themoviedb.org
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

}

/**
 * The Exception class for TMDb specific exceptions.
 *
 * Defining to be compatible with Drupal coding
 * standards. We might extend this class per need.
 */
class TMDbException extends Exception{}