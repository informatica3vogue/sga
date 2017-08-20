<?php
/**
 * @package dompdf
 * @link    http://dompdf.github.com/
 * @author  Benj Carson <benjcarson@digitaljunkies.ca>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */

/**
 * Base Frame_Decorator class
 *
 * @access private
 * @package dompdf
 */
abstract class Frame_Decorator extends Frame {
  const DEFAULT_COUNTER = "-dompdf-default-counter";
  
  public $_counters = array(); // array([id] => counter_value) (for generated content)
  
  /**
   * The root node of the DOM tree
   *
   * @var Frame
   */
  protected $_root;

  /**
   * The decorated frame
   *
   * @var Frame
   */
  protected $_frame;

  /**
   * Positioner object used to position this frame (Strategy pattern)
   *
   * @var Positioner
   */
  protected $_positioner;

  /**
   * Reflower object used to calculate frame dimensions (Strategy pattern)
   *
   * @var Frame_Reflo