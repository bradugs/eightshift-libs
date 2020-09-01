<?php
/**
 * Class that registers WPCLI command initial setup of theme project.
 * 
 * Command Develop:
 * wp eval-file bin/cli.php init_theme --skip-wordpress
 *
 * @package EightshiftLibs\Cli
 */

namespace EightshiftLibs\Cli;

use EightshiftLibs\Cli\AbstractCli;

/**
 * Class CliInitTheme
 */
class CliInitTheme extends AbstractCli {

  /**
   * Get WPCLI command name
   *
   * @return string
   */
  public function get_command_name() : string {
    return 'init_theme';
  }

  /**
   * Get WPCLI trigger class name.
   *
   * @return string
   */
  public function get_class_name() : string {
    return CliInitTheme::class;
  }

  /**
   * Get WPCLI command doc.
   *
   * @return string
   */
  public function get_doc() : array {
    return [
      'shortdesc' => 'Generates initial setup for WordPress theme project.',
    ];
  }

  public function __invoke( array $args, array $assoc_args ) {

    \WP_CLI::log( "COMMANDS FOR WP-CLI:" );

    foreach ( Cli::INIT_THEME_CLASSES as $item ) {
      $class_name = new $item;


      \WP_CLI::runcommand( "{$class_name->get_command_name()}" );
    }
  }
}
