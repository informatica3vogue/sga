<?php
/**
 * @package php-font-lib
 * @link    https://github.com/PhenX/php-font-lib
 * @author  Fabien Ménager <fabien.menager@gmail.com>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: Font_Table_glyf.php 46 2012-04-02 20:22:38Z fabien.menager $
 */

require_once dirname(__FILE__) . "/Font_Glyph_Outline_Component.php";

/**
 * Composite glyph outline
 *
 * @package php-font-lib
 */
class Font_Glyph_Outline_Composite extends Font_Glyph_Outline {
  const ARG_1_AND_2_ARE_WORDS    = 0x0001;
  const ARGS_ARE_XY_VALUES       = 0x0002;
  const ROUND_XY_TO_GRID         = 0x0004;
  const WE_HAVE_A_SCALE          = 0x0008;
  const MORE_COMPONENTS          = 0x0020;
  const WE_HAVE_AN_X_AND_Y_SCALE = 0x0040;
  const WE_HAVE_A_TWO_BY_TWO     = 0x0080;
  const WE_HAVE_INSTRUCTIONS     = 0x0100;
  const USE_MY_METRICS           = 0x0200;
  const OVERLAP_COMPOUND         =