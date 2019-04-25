<?php
/**
 * Interface for blocks.
 *
 * @since   0.1.0
 * @package Eightshift_Libs\Blocks
 */

namespace Eightshift_Libs\Blocks;

/**
 * Interface Block
 */
interface Block {

  /**
   * Get all block attributes. Default and block attributes.
   *
   * @return array
   *
   * @since 0.1.0
   */
  public function get_attributes() : array;
}
