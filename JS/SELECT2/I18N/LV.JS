<?php
/**
 * @package dompdf
 * @link    http://dompdf.github.com/
 * @author  Benj Carson <benjcarson@digitaljunkies.ca>
 * @author  Helmut Tischer <htischer@weihenstephan.org>
 * @author  Fabien Ménager <fabien.menager@gmail.com>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */

/**
 * Static class that resolves image urls and downloads and caches
 * remote images if required.
 *
 * @access private
 * @package dompdf
 */
class Image_Cache {

  /**
   * Array of downloaded images.  Cached so that identical images are
   * not needlessly downloaded.
   *
   * @var array
   */
  static protected $_cache = array();
  
  /**
   * The url to the "broken image" used when images can't be loade
   * 
   * @var string
   */
  public static $broken_image;

  /**
   * Resolve and fetch an image for use.
   *
   * @param string $ur