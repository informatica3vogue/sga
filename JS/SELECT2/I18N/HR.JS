<?php
/**
 * @package dompdf
 * @link    http://dompdf.github.com/
 * @author  Benj Carson <benjcarson@digitaljunkies.ca>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */

/**
 * Represents an entire document as a tree of frames
 *
 * The Frame_Tree consists of {@link Frame} objects each tied to specific
 * DOMNode objects in a specific DomDocument.  The Frame_Tree has the same
 * structure as the DomDocument, but adds additional capabalities for
 * styling and layout.
 *
 * @package dompdf
 * @access protected
 */
class Frame_Tree {
    
  /**
   * Tags to ignore while parsing the tree
   *
   * @var array
   */
  static protected $_HIDDEN_TAGS = array("area", "base", "basefont", "head", "style",
                                  