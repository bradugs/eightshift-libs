<?php
/**
 * The Media specific functionality.
 *
 * @package EightshiftLibs\Media
 */

declare( strict_types=1 );

namespace EightshiftLibs\Media;

use EightshiftLibs\Media\AbstractMedia;

/**
 * Class Media
 *
 * This class handles all media options. Sizes, Types, Features, etc.
 */
class Media extends AbstractMedia {

  /**
   * Register all the hooks
   *
   * @return void
   */
  public function register() {
    add_action( 'after_setup_theme', [ $this, 'add_theme_support' ], 20 );
  }
}
